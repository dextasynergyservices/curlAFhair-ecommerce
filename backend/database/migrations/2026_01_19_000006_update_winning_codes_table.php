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
        Schema::table('winning_codes', function (Blueprint $table) {
            $table->boolean('is_used')->default(false)->after('code');
            $table->foreignId('used_by')->nullable()->constrained('users')->onDelete('set null')->after('is_used');
            $table->timestamp('used_at')->nullable()->after('used_by');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null')->after('used_at');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null')->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('winning_codes', function (Blueprint $table) {
            $table->dropForeign(['used_by']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['order_id']);
            $table->dropColumn(['is_used', 'used_by', 'used_at', 'product_id', 'order_id']);
        });
    }
};
