<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id');
            $table->dateTime('order_date');
            $table->dateTime('order_date_of_delivery');
            // order_status
            $table->unsignedBigInteger('order_status_id');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
            // order_client (user)
            $table->unsignedBigInteger('order_client_id');
            $table->foreign('order_client_id')->references('id')->on('users')->onDelete('cascade');
            // order_distributor (user)
            $table->unsignedBigInteger('order_distributor_id');
            $table->foreign('order_distributor_id')->references('id')->on('users')->onDelete('cascade');
            // order_type
            $table->unsignedBigInteger('order_type_id');
            $table->foreign('order_type_id')->references('id')->on('order_types')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
