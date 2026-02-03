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
        Schema::table('users', function (Blueprint $table) {
            // Modifier la colonne registered_at pour s'assurer qu'elle est de type timestamp
            $table->timestamp('registered_at')->nullable()->change();
            
            // Mettre à jour les enregistrements existants qui n'ont pas de registered_at
            DB::statement('UPDATE users SET registered_at = created_at WHERE registered_at IS NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
