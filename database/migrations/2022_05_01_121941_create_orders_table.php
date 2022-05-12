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
            $table->id();
            $table->string('order_type');
            $table->text('address');
            $table->string('customer_name');
            $table->string('uuid')->unique();
            $table->foreignId('restorant_id');
            $table->string('customer_phone')->nullable();
            $table->integer('delivery_fee')->nullable();
            $table->foreignId('checkout_id')->nullable();
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
