<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('bar_admission_year')->nullable()->default('2009')->after('years_experience');

            $table->json('practice_title')->nullable()->after('about_text');
            $table->json('practice_subtitle')->nullable()->after('practice_title');
            $table->json('practice_banner_title')->nullable()->after('practice_subtitle');
            $table->json('practice_banner_text')->nullable()->after('practice_banner_title');

            $table->json('pledge_title')->nullable()->after('practice_banner_text');
            $table->json('pledge_subtitle')->nullable()->after('pledge_title');
            $table->json('pledge_sign_text')->nullable()->after('pledge_subtitle');
            $table->json('pledge_clauses')->nullable()->after('pledge_sign_text');

            $table->json('route_title')->nullable()->after('pledge_clauses');
            $table->json('route_subtitle')->nullable()->after('route_title');
            $table->json('route_stages')->nullable()->after('route_subtitle');

            $table->json('messages_title')->nullable()->after('route_stages');
            $table->json('messages_subtitle')->nullable()->after('messages_title');
            $table->json('messages_items')->nullable()->after('messages_subtitle');

            $table->json('faq_title')->nullable()->after('messages_items');
            $table->json('faq_subtitle')->nullable()->after('faq_title');

            $table->json('booking_title')->nullable()->after('faq_subtitle');
            $table->json('booking_subtitle')->nullable()->after('booking_title');

            $table->json('contact_title')->nullable()->after('booking_subtitle');
            $table->json('contact_subtitle')->nullable()->after('contact_title');

            $table->json('footer_text')->nullable()->after('contact_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'bar_admission_year',
                'practice_title',
                'practice_subtitle',
                'practice_banner_title',
                'practice_banner_text',
                'pledge_title',
                'pledge_subtitle',
                'pledge_sign_text',
                'pledge_clauses',
                'route_title',
                'route_subtitle',
                'route_stages',
                'messages_title',
                'messages_subtitle',
                'messages_items',
                'faq_title',
                'faq_subtitle',
                'booking_title',
                'booking_subtitle',
                'contact_title',
                'contact_subtitle',
                'footer_text',
            ]);
        });
    }
};
