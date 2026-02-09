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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // Insérer les paramètres par défaut
        DB::table('settings')->insert([
            [
                'key' => 'site_name',
                'value' => 'ZTF Foundation',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_description',
                'value' => 'Plateforme de gestion ZTF Foundation',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'two_factor_auth',
                'value' => 'false',
                'group' => 'security',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'force_password_change',
                'value' => 'false',
                'group' => 'security',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'session_lifetime',
                'value' => '120',
                'group' => 'security',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
