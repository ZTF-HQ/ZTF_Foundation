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
        Schema::table('departments', function (Blueprint $table) {
            $table->boolean('email_notifications')->default(true);
            $table->enum('report_frequency', ['daily', 'weekly', 'monthly'])->default('weekly');
            $table->boolean('two_factor_enabled')->default(false);
            $table->integer('session_timeout')->default(30);
            $table->enum('theme', ['light', 'dark', 'system'])->default('system');
            $table->enum('language', ['fr', 'en'])->default('fr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn([
                'email_notifications',
                'report_frequency',
                'two_factor_enabled',
                'session_timeout',
                'theme',
                'language'
            ]);
        });
    }
};
