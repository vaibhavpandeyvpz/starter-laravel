<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLockingColumnsToUsersAndRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->lockVersion();
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->lockVersion();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropLockVersion();
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropLockVersion();
        });
    }
}
