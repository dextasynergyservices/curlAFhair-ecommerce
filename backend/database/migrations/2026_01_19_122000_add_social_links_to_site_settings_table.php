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
            $table->string('facebook_url')->nullable()->after('footer_text');
            $table->string('twitter_url')->nullable()->after('facebook_url');
            $table->string('instagram_url')->nullable()->after('twitter_url');
            $table->string('tiktok_url')->nullable()->after('instagram_url');
            $table->string('youtube_url')->nullable()->after('tiktok_url');
            $table->string('currency', 10)->default('NGN')->after('youtube_url');
            $table->string('currency_symbol', 5)->default('₦')->after('currency');
            $table->string('meta_title', 100)->nullable()->after('currency_symbol');
            $table->string('meta_description', 300)->nullable()->after('meta_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'facebook_url',
                'twitter_url',
                'instagram_url',
                'tiktok_url',
                'youtube_url',
                'currency',
                'currency_symbol',
                'meta_title',
                'meta_description',
            ]);
        });
    }
};
