<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCarModelsTable extends Migration
{
    public function up()
    {
        Schema::table('car_models', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id', 'brand_fk_7776800')->references('id')->on('brands');
        });
    }
}
