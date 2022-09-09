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
            $table->id('id');
            $table->string('user_name');
            $table->string('user_surnames')->nullable();
            $table->string('user_email')->unique();
            $table->string('user_profile_picture')->nullable();
            $table->boolean('user_receive_notifications')->nullable()->default(true);
            $table->boolean('user_receive_recommendation')->nullable()->default(true);
            // users_type_of_user
            $table->unsignedBigInteger('type_of_user_id');
            $table->foreign('type_of_user_id')->references('id')->on('type_of_users')->onDelete('cascade');
            //$table->rememberToken();
            $table->softDeletes();
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
