<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id'); //systems
            $table->string('active', 1);
            $table->string('username', 50)->unique()->nullable();
            $table->string('name', 50)->nullable(); //systems
            $table->string('last_name', 50)->nullable();
            $table->string('second_name', 50)->nullable();
            $table->string('email'); //systems
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); //systems
            $table->string('checkword', 50)->nullable();
            $table->integer('personal_photo')->unsigned()->nullable();
            $table->string('personal_phone')->nullable();
            $table->char('personal_gender', 1)->nullable();
            $table->string('personal_birthdate', 50)->nullable();
            $table->string('personal_mobile')->nullable();
            $table->string('personal_city')->nullable();
            $table->string('external_auth_id')->nullable();
            $table->string('confirm_code', 8);
            $table->dateTime('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
