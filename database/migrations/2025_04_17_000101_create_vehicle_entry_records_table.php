<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleEntryRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_entry_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('date_time');
            $table->integer('battery_enter');
            $table->integer('battery_exit');
            $table->integer('quilometers');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
