<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;
use App\Models\WinningCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Get or create cart for the current user/session
     */
    protected function getCart()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            
            // Merge session cart if exists
            $sessionId = session()->get('cart_session_id');
            if ($sessionId) {
                $sessionCart = Cart::where('session_id', $sessionId)->first();
                if ($sessionCart && $sessionCart->id !== $cart->id) {
                    // Merge session cart items to user cart
                    foreach ($sessionCart->items as $item) {
                        $existingItem = $cart->items()
                            ->where('product_id', $item->product_id)
                            ->where('product_variant_id', $item->product_variant_id)
                            ->first();

                        if ($existingItem) {
                            $existingItem->increment('quantity', $item->quantity);
                        } else {
                            $item->update(['cart_id' => $cart->id]);
                        }
                    }
                    $sessionCart->delete();
                    session()->forget('cart_session_id');
                }
            }
        } else {
            $sessionId = session()->get('cart_session_id');
            if (!$sessionId) {
                $sessionId = Str::uuid()->toString();
                session()->put('cart_session_id', $sessionId);
            }
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }

        return $cart->load('items.product', 'items.variant');
    }

    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = $this->getCart();
        return view('frontend.cart', compact('cart'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $product = Product::active()->findOrFail($request->product_id);
        
        // Check stock
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = $this->getCart();

        $cartItem = $cart->items()
            ->where('product_id', $request->product_id)
            ->where('product_variant_id', $request->variant_id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cartItem->increment('quantity', $request->quantity);
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'product_variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => $cart->fresh()->items_count,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        // Check stock
        if ($cartItem->product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        if ($request->ajax()) {
            $cart = $this->getCart();
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'subtotal' => number_format($cart->subtotal, 2),
                'cart_count' => $cart->items_count,
                'item_total' => number_format($cartItem->total_price, 2),
            ]);
        }

        return back()->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart
     */
    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();

        if (request()->ajax()) {
            $cart = $this->getCart();
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'subtotal' => number_format($cart->subtotal, 2),
                'cart_count' => $cart->items_count,
            ]);
        }

        return back()->with('success', 'Item removed from cart!');
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        $cart = $this->getCart();
        $cart->clear();

        return back()->with('success', 'Cart cleared!');
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid coupon code.');
        }

        if (!$coupon->isValid()) {
            return back()->with('error', 'This coupon is no longer valid.');
        }

        if (Auth::check() && !$coupon->canBeUsedByUser(Auth::id())) {
            return back()->with('error', 'You have already used this coupon.');
        }

        $cart = $this->getCart();
        $discount = $coupon->calculateDiscount($cart->subtotal);

        if ($discount <= 0) {
            if ($coupon->min_order_amount) {
                return back()->with('error', "Minimum order amount of ₦" . number_format($coupon->min_order_amount, 2) . " required.");
            }
            return back()->with('error', 'This coupon cannot be applied to your order.');
        }

        // Store coupon in session
        session()->put('applied_coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount' => $discount,
        ]);

        return back()->with('success', 'Coupon applied! You save ₦' . number_format($discount, 2));
    }

    /**
     * Remove coupon
     */
    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        session()->forget('applied_promo');
        return back()->with('success', 'Coupon removed.');
    }

    /**
     * Apply promo winning code (100% discount)
     */
    public function applyPromoCode(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string',
        ]);

        if (!Auth::check()) {
            return back()->with('error', 'Please login to use your winning promo code.');
        }

        $winningCode = WinningCode::where('code', strtoupper($request->promo_code))->first();

        if (!$winningCode) {
            return back()->with('error', 'Invalid promo code.');
        }

        if (!$winningCode->isAvailable()) {
            return back()->with('error', 'This promo code has already been used.');
        }

        // Store promo code in session (100% discount)
        session()->put('applied_promo', [
            'code' => $winningCode->code,
            'id' => $winningCode->id,
        ]);

        // Remove any regular coupon
        session()->forget('applied_coupon');

        return back()->with('success', 'Congratulations! Your winning promo code has been applied. Your order will be FREE!');
    }

    /**
     * Get cart count for AJAX
     */
    public function count()
    {
        $cart = $this->getCart();
        return response()->json(['count' => $cart->items_count]);
    }
}
