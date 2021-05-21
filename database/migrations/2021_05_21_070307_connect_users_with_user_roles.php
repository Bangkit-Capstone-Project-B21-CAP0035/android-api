<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectUsersWithUserRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->primary(['user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropForeign(['role_id', 'user_id']);
        });
    }
}
