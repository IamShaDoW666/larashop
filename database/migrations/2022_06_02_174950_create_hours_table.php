<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restorant_id');
            $table->string('m_from')->nullable()->default('00:01');
            $table->string('m_to')->nullable()->default('23:58');
            $table->string('t_from')->nullable()->default('00:01');
            $table->string('t_to')->nullable()->default('23:58');
            $table->string('w_from')->nullable()->default('00:01');
            $table->string('w_to')->nullable()->default('23:58');
            $table->string('th_from')->nullable()->default('00:01');
            $table->string('th_to')->nullable()->default('23:58');
            $table->string('f_from')->nullable()->default('00:01');
            $table->string('f_to')->nullable()->default('23:58');
            $table->string('s_from')->nullable()->default('00:01');
            $table->string('s_to')->nullable()->default('23:58');
            $table->string('su_from')->nullable()->default('00:01');
            $table->string('su_to')->nullable()->default('23:58');
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
        Schema::dropIfExists('hours');
    }
}
