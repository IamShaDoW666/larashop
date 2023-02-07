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
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->string('status')->default('pending');
            $table->text('address')->nullable();
            $table->string('order_type');
            $table->string('payment_method')->nullable();
            $table->string('uuid')->unique()->nullable();
            $table->foreignId('grocery_id');
            $table->unsignedInteger('total');
            $table->unsignedInteger('subtotal')->nullable();
            $table->integer('delivery_fee')->nullable();
            $table->unsignedInteger('tax')->nullable();
            $table->string('tax_name')->nullable();
            $table->unsignedInteger('tax_percent')->nullable();
            $table->timestamp('order_time')->nullable();
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
