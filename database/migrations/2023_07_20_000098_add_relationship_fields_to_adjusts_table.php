<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAdjustsTable extends Migration
{
    public function up()
    {
        Schema::table('adjusts', function (Blueprint $table) {
            $table->unsignedBigInteger('tvde_week_id')->nullable();
            $table->foreign('tvde_week_id', 'tvde_week_fk_8773746')->references('id')->on('tvde_weeks');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id', 'driver_fk_8773747')->references('id')->on('drivers');
        });
    }
}
