<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Shipping information
            $table->string('first_name')->nullable()->after('total');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('email')->nullable()->after('last_name');
            $table->string('phone')->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('state');
            $table->string('country')->default('Nigeria')->after('postal_code');
            
            // Payment information
            $table->string('payment_method')->nullable()->after('country'); // paystack, paypal, stripe
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->string('payment_reference')->nullable()->after('payment_status');
            $table->string('transaction_id')->nullable()->after('payment_reference');
            $table->string('currency')->default('NGN')->after('transaction_id');
            
            // Pricing breakdown
            $table->decimal('subtotal', 10, 2)->default(0)->after('currency');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('subtotal');
            $table->decimal('shipping_fee', 10, 2)->default(0)->after('discount_amount');
            
            // Coupon/Promo
            $table->string('coupon_code')->nullable()->after('shipping_fee');
            $table->string('promo_code')->nullable()->after('coupon_code');
            $table->boolean('is_promo_order')->default(false)->after('promo_code');
            
            // Notes
            $table->text('notes')->nullable()->after('is_promo_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'email', 'phone', 
                'address', 'city', 'state', 'postal_code', 'country',
                'payment_method', 'payment_status', 'payment_reference', 
                'transaction_id', 'currency', 'subtotal', 'discount_amount',
                'shipping_fee', 'coupon_code', 'promo_code', 'is_promo_order', 'notes'
            ]);
        });
    }
};
