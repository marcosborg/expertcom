<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandCarsTable extends Migration
{
    public function up()
    {
        Schema::create('stand_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transmision');
            $table->float('cylinder_capacity', 6, 2)->nullable();
            $table->integer('battery_capacity')->nullable();
            $table->integer('year');
            $table->string('kilometers');
            $table->integer('power');
            $table->string('distance');
            $table->decimal('price', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
