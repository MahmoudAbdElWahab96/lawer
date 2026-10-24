<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->json('lawyer_name')->nullable();
            $table->json('lawyer_title')->nullable();
            $table->json('hero_headline')->nullable();
            $table->json('hero_subheadline')->nullable();
            $table->json('about_title')->nullable();
            $table->json('about_text')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->json('address')->nullable();
            $table->json('working_hours')->nullable();
            $table->text('map_embed_url')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('x_url')->nullable();
            $table->string('youtube')->nullable();
            $table->unsignedInteger('years_experience')->default(0);
            $table->unsignedInteger('cases_count')->default(0);
            $table->unsignedInteger('clients_count')->default(0);
            $table->string('logo_path')->nullable();
            $table->string('hero_image_path')->nullable();
            $table->json('seo_meta_title')->nullable();
            $table->json('seo_meta_description')->nullable();
            $table->json('seo_keywords')->nullable();
            $table->string('seo_og_image_path')->nullable();
            $table->boolean('seo_robots_index')->default(true);
            $table->string('google_verification')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
