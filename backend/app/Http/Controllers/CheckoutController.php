<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\WinningCode;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index()
    {
        if (!Auth::check()) {
            // Store intended URL so user returns here after login
            return redirect()->guest(route('login'))->with('error', 'Please login to checkout.');
        }

        $cart = Cart::where('user_id', Auth::id())->with('items.product', 'items.variant')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cart->subtotal;
        $discount = 0;
        $appliedCoupon = session()->get('applied_coupon');
        $appliedPromo = session()->get('applied_promo');
        $isPromoOrder = false;

        if ($appliedPromo) {
            // Promo code gives 100% discount
            $discount = $subtotal;
            $isPromoOrder = true;
        } elseif ($appliedCoupon) {
            $discount = $appliedCoupon['discount'];
        }

        $shippingFee = $isPromoOrder ? 0 : 1500; // Free shipping for promo orders
        $total = max(0, $subtotal - $discount + $shippingFee);

        $user = Auth::user();
        
        // Get enabled payment methods from settings
        $settings = SiteSetting::getSettings();
        $paymentMethods = $settings->getEnabledPaymentMethods();

        return view('frontend.checkout', compact(
            'cart', 
            'subtotal', 
            'discount', 
            'shippingFee', 
            'total', 
            'appliedCoupon', 
            'appliedPromo',
            'isPromoOrder',
            'user',
            'paymentMethods'
        ));
    }

    /**
     * Process the checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'payment_method' => 'required|in:paystack,paypal,stripe,bank_transfer,cod',
            'notes' => 'nullable|string|max:1000',
        ]);

        if (!Auth::check()) {
            return redirect()->guest(route('login'))->with('error', 'Please login to checkout.');
        }

        $cart = Cart::where('user_id', Auth::id())->with('items.product', 'items.variant')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = $cart->subtotal;
        $discount = 0;
        $appliedCoupon = session()->get('applied_coupon');
        $appliedPromo = session()->get('applied_promo');
        $isPromoOrder = false;
        $couponCode = null;
        $promoCode = null;

        if ($appliedPromo) {
            $discount = $subtotal;
            $isPromoOrder = true;
            $promoCode = $appliedPromo['code'];
        } elseif ($appliedCoupon) {
            $discount = $appliedCoupon['discount'];
            $couponCode = $appliedCoupon['code'];
        }

        $shippingFee = $isPromoOrder ? 0 : 1500;
        $total = max(0, $subtotal - $discount + $shippingFee);

        // Determine currency based on payment method
        $currency = 'NGN';
        if ($request->payment_method === 'paypal' || $request->payment_method === 'stripe') {
            $currency = 'USD';
            // Convert NGN to USD (approximate rate)
            $total = round($total / 1500, 2);
            $subtotal = round($subtotal / 1500, 2);
            $discount = round($discount / 1500, 2);
            $shippingFee = round($shippingFee / 1500, 2);
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'status' => Order::STATUS_PENDING,
                'total' => $total,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'payment_method' => $request->payment_method,
                'payment_status' => Order::PAYMENT_PENDING,
                'currency' => $currency,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'shipping_fee' => $shippingFee,
                'coupon_code' => $couponCode,
                'promo_code' => $promoCode,
                'is_promo_order' => $isPromoOrder,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_name' => $item->product->name,
                    'variant_name' => $item->variant ? $item->variant->quantity : null,
                    'unit_price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'total_price' => $item->total_price,
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Mark coupon as used
            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->first();
                if ($coupon) {
                    CouponUsage::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => Auth::id(),
                        'order_id' => $order->id,
                    ]);
                    $coupon->increment('used_count');
                }
            }

            // Mark promo code as used
            if ($appliedPromo) {
                $winningCode = WinningCode::find($appliedPromo['id']);
                if ($winningCode) {
                    $winningCode->markAsUsed(Auth::id(), $order->id);
                }
            }

            DB::commit();

            // Store order ID in session for payment callback
            session()->put('pending_order_id', $order->id);

            // Clear session data
            session()->forget(['applied_coupon', 'applied_promo']);

            // Redirect to payment based on method
            return $this->initiatePayment($order);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred during checkout. Please try again.');
        }
    }

    /**
     * Initiate payment based on payment method
     */
    protected function initiatePayment(Order $order)
    {
        switch ($order->payment_method) {
            case 'paystack':
                return $this->initiatePaystack($order);
            case 'paypal':
                return $this->initiatePaypal($order);
            case 'stripe':
                return $this->initiateStripe($order);
            default:
                return redirect()->route('orders.show', $order)->with('error', 'Invalid payment method.');
        }
    }

    /**
     * Initiate Paystack payment
     */
    protected function initiatePaystack(Order $order)
    {
        $paystackUrl = "https://api.paystack.co/transaction/initialize";
        $amountInKobo = $order->total * 100; // Paystack expects amount in kobo

        $fields = [
            'email' => $order->email,
            'amount' => $amountInKobo,
            'currency' => 'NGN',
            'reference' => $order->order_number,
            'callback_url' => route('payment.callback.paystack'),
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ],
        ];

        $fieldsString = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paystackUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . config('services.paystack.secret_key'),
            "Cache-Control: no-cache",
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($result && $result['status'] === true) {
            $order->update(['payment_reference' => $result['data']['reference']]);
            return redirect($result['data']['authorization_url']);
        }

        Log::error('Paystack initialization failed: ' . $response);
        return redirect()->route('orders.show', $order)->with('error', 'Payment initialization failed. Please try again.');
    }

    /**
     * Handle Paystack callback
     */
    public function paystackCallback(Request $request)
    {
        $reference = $request->get('reference');
        
        if (!$reference) {
            return redirect()->route('cart.index')->with('error', 'Invalid payment reference.');
        }

        $paystackUrl = "https://api.paystack.co/transaction/verify/" . $reference;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paystackUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . config('services.paystack.secret_key'),
            "Cache-Control: no-cache",
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($result && $result['status'] === true && $result['data']['status'] === 'success') {
            $order = Order::where('payment_reference', $reference)->first();
            
            if ($order) {
                $order->update([
                    'payment_status' => Order::PAYMENT_PAID,
                    'transaction_id' => $result['data']['id'],
                    'status' => Order::STATUS_PROCESSING,
                ]);

                // Clear cart
                Cart::where('user_id', Auth::id())->first()?->clear();

                return redirect()->route('order.success', $order)->with('success', 'Payment successful! Your order has been placed.');
            }
        }

        return redirect()->route('cart.index')->with('error', 'Payment verification failed. Please contact support.');
    }

    /**
     * Initiate PayPal payment
     */
    protected function initiatePaypal(Order $order)
    {
        // For simplicity, we'll redirect to a form that will submit to PayPal
        return view('frontend.paypal-redirect', compact('order'));
    }

    /**
     * Handle PayPal callback
     */
    public function paypalCallback(Request $request)
    {
        // PayPal IPN/Webhook handling
        $orderId = session()->get('pending_order_id');
        $order = Order::find($orderId);

        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }

        // In production, verify with PayPal API
        if ($request->has('PayerID') && $request->has('paymentId')) {
            $order->update([
                'payment_status' => Order::PAYMENT_PAID,
                'transaction_id' => $request->paymentId,
                'status' => Order::STATUS_PROCESSING,
            ]);

            Cart::where('user_id', Auth::id())->first()?->clear();

            return redirect()->route('order.success', $order)->with('success', 'Payment successful!');
        }

        return redirect()->route('cart.index')->with('error', 'Payment was cancelled.');
    }

    /**
     * Initiate Stripe payment
     */
    protected function initiateStripe(Order $order)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Order #' . $order->order_number,
                        ],
                        'unit_amount' => $order->total * 100, // Stripe expects amount in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.callback.stripe') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('orders.show', $order),
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            $order->update(['payment_reference' => $session->id]);

            return redirect($session->url);
        } catch (\Exception $e) {
            Log::error('Stripe initialization failed: ' . $e->getMessage());
            return redirect()->route('orders.show', $order)->with('error', 'Payment initialization failed.');
        }
    }

    /**
     * Handle Stripe callback
     */
    public function stripeCallback(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('cart.index')->with('error', 'Invalid session.');
        }

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $order = Order::where('payment_reference', $sessionId)->first();

                if ($order) {
                    $order->update([
                        'payment_status' => Order::PAYMENT_PAID,
                        'transaction_id' => $session->payment_intent,
                        'status' => Order::STATUS_PROCESSING,
                    ]);

                    Cart::where('user_id', Auth::id())->first()?->clear();

                    return redirect()->route('order.success', $order)->with('success', 'Payment successful!');
                }
            }
        } catch (\Exception $e) {
            Log::error('Stripe callback error: ' . $e->getMessage());
        }

        return redirect()->route('cart.index')->with('error', 'Payment verification failed.');
    }

    /**
     * Order success page
     */
    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('frontend.order-success', compact('order'));
    }
}
