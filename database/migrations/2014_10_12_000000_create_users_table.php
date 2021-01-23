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
            $table->string('name');
            $table->string('email');
            $table->integer('public_repo')->default(0);
            $table->integer('commit_sum')->default(0);
            $table->integer('issues')->default(0);
            $table->integer('pull_requests')->default(0);
            $table->integer('star_sum')->default(0);
            $table->integer('followers')->default(0);
            $table->string('user_rank')->default('B+');
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
