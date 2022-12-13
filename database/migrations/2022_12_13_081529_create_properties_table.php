<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')->unsigned();
            $table->string("property_name", 255);
            $table->tinyInteger('near_beach')->unsigned()->default(0);
            $table->tinyInteger('accepts_pets')->unsigned()->default(0);
            $table->tinyInteger('sleeps')->unsigned()->default(1);
            $table->tinyInteger('beds')->unsigned()->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
