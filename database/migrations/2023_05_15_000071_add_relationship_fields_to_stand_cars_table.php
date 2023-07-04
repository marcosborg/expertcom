<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStandCarsTable extends Migration
{
    public function up()
    {
        Schema::table('stand_cars', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id', 'brand_fk_7776804')->references('id')->on('brands');
            $table->unsignedBigInteger('car_model_id')->nullable();
            $table->foreign('car_model_id', 'car_model_fk_7776805')->references('id')->on('car_models');
            $table->unsignedBigInteger('fuel_id')->nullable();
            $table->foreign('fuel_id', 'fuel_fk_7746442')->references('id')->on('fuels');
            $table->unsignedBigInteger('month_id')->nullable();
            $table->foreign('month_id', 'month_fk_7757630')->references('id')->on('months');
            $table->unsignedBigInteger('origin_id')->nullable();
            $table->foreign('origin_id', 'origin_fk_7757633')->references('id')->on('origins');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_7757651')->references('id')->on('statuses');
        });
    }
}
