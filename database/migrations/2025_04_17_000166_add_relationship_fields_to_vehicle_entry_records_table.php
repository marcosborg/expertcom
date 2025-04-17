<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVehicleEntryRecordsTable extends Migration
{
    public function up()
    {
        Schema::table('vehicle_entry_records', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_10537299')->references('id')->on('users');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id', 'driver_fk_10537300')->references('id')->on('drivers');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id', 'vehicle_fk_10537301')->references('id')->on('vehicle_items');
        });
    }
}
