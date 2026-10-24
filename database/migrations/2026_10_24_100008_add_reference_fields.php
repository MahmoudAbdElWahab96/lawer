<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedTinyInteger('success_rate')->default(0)->after('clients_count');
            $table->unsignedInteger('lawyers_count')->default(0)->after('success_rate');
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->foreignId('practice_area_id')
                ->nullable()
                ->after('email')
                ->constrained('practice_areas')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('practice_area_id');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['success_rate', 'lawyers_count']);
        });
    }
};
