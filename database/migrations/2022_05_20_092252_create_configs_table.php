<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restorant_id')->nullable();
            $table->boolean('can_order')->default(false);
            $table->boolean('can_deliver')->default(false);
            $table->boolean('can_dinein')->default(false);
            $table->boolean('can_pickup')->default(false);
            $table->integer('minimum_order')->default(0);
            $table->string('currency')->default('INR');
            $table->integer('tax')->nullable();
            $table->string('tax_name')->nullable();
            $table->integer('minimum_order_free')->nullable()->default(null);
            $table->string('razorpay_api_key')->nullable();
            $table->string('razorpay_api_secret')->nullable();
            $table->string('stripe_api_key')->nullable();
            $table->string('stripe_api_secret')->nullable();
            $table->string('google_maps_api_key')->nullable();
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
        Schema::dropIfExists('configs');
    }
}
