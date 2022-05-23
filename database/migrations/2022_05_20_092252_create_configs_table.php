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
            $table->integer('minimum_order_free')->nullable()->default(null);
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
