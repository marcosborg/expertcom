<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentDriverPivotTable extends Migration
{
    public function up()
    {
        Schema::create('adjustment_driver', function (Blueprint $table) {
            $table->unsignedBigInteger('adjustment_id');
            $table->foreign('adjustment_id', 'adjustment_id_fk_8799654')->references('id')->on('adjustments')->onDelete('cascade');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id', 'driver_id_fk_8799654')->references('id')->on('drivers')->onDelete('cascade');
        });
    }
}
