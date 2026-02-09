<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeToRolesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('code')->nullable()->after('name');
        });

        // Update existing roles with their codes
        DB::table('roles')->where('name', 'super-admin')->update(['code' => 'SPAD']);
        DB::table('roles')->where('name', 'admin-1')->update(['code' => 'NEH']);
        DB::table('roles')->where('name', 'admin-2')->update(['code' => 'CD']);
        DB::table('roles')->where('name', 'staff')->update(['code' => 'STF']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}