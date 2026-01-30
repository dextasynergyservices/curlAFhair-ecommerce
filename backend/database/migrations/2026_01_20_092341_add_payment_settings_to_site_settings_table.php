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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('payment_paystack_enabled')->default(true)->after('meta_description');
            $table->boolean('payment_paypal_enabled')->default(false)->after('payment_paystack_enabled');
            $table->boolean('payment_stripe_enabled')->default(false)->after('payment_paypal_enabled');
            $table->boolean('payment_bank_transfer_enabled')->default(false)->after('payment_stripe_enabled');
            $table->boolean('payment_cod_enabled')->default(false)->after('payment_bank_transfer_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_paystack_enabled',
                'payment_paypal_enabled',
                'payment_stripe_enabled',
                'payment_bank_transfer_enabled',
                'payment_cod_enabled',
            ]);
        });
    }
};
