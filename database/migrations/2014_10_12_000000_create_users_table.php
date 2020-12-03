<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('real_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->string('gender')->default('none')->comment('性别：none/female/male');
            $table->string('phone')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->string('password')->nullable();
            $table->string('status')->default('inactivated')->comment('状态：inactivated/active/frozen');
            $table->timestamp('frozen_at')->nullable();
            $table->timestamp('status_remark')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
