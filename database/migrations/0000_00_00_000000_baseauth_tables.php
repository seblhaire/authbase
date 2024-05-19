<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BaseauthTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
           $table->increments('id');
           $table->string('name');
           $table->timestamps();
           $table->softDeletes();
       });
       Schema::create('role_user', function (Blueprint $table) {
           $table->integer('role_id');
           $table->integer('user_id');
           $table->index('role_id');
           $table->index('user_id');
       });
       Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('profile_user', function (Blueprint $table) {
            $table->integer('user_id')->index();
            $table->integer('profile_id')->index();
            $table->json('jsonvals');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
        Schema::drop('role_user');
        Schema::drop('profiles');
        Schema::drop('profile_user');
    }
}
