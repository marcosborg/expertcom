<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStandCarFormsTable extends Migration
{
    public function up()
    {
        Schema::table('stand_car_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->nullable();
            $table->foreign('car_id', 'car_fk_7807568')->references('id')->on('stand_cars');
        });
    }
}
