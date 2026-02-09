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
        Schema::create('first_registration_users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('first_email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('first_password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('first_registration_users');
    }
};
