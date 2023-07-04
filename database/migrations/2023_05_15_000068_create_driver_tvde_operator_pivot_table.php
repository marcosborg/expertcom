<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverTvdeOperatorPivotTable extends Migration
{
    public function up()
    {
        Schema::create('driver_tvde_operator', function (Blueprint $table) {
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id', 'driver_id_fk_8087850')->references('id')->on('drivers')->onDelete('cascade');
            $table->unsignedBigInteger('tvde_operator_id');
            $table->foreign('tvde_operator_id', 'tvde_operator_id_fk_8087850')->references('id')->on('tvde_operators')->onDelete('cascade');
        });
    }
}
