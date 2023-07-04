<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToActivityLaunchesTable extends Migration
{
    public function up()
    {
        Schema::table('activity_launches', function (Blueprint $table) {
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id', 'driver_fk_8084062')->references('id')->on('drivers');
            $table->unsignedBigInteger('week_id')->nullable();
            $table->foreign('week_id', 'week_fk_8084063')->references('id')->on('tvde_weeks');
        });
    }
}
