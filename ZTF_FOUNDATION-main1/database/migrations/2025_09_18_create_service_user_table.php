<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('service_user')) {
            Schema::create('service_user', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('service_id');
                $table->unsignedBigInteger('user_id');
                $table->timestamps();

                $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                $table->unique(['service_id', 'user_id']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('service_user');
    }
};