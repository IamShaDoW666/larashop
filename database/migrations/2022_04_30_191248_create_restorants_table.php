<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestorantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restorants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('uuid');
            $table->foreignId('user_id');
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->double('lat')->default(11.874328767638222);
            $table->double('lng')->default(75.37777413902285);
            $table->string('banner')->default('/imgs/3c993253-f980-4e4c-b8a9-f58bedeef541_large.webp');
            $table->string('logo')->default('/imgs/3c993253-f980-4e4c-b8a9-f58bedeef541_thumbnail.webp');
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
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
        Schema::dropIfExists('restorants');
    }
}
