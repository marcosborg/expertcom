<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToActivityPerOperatorsTable extends Migration
{
    public function up()
    {
        Schema::table('activity_per_operators', function (Blueprint $table) {
            $table->unsignedBigInteger('activity_launch_id')->nullable();
            $table->foreign('activity_launch_id', 'activity_launch_fk_8087826')->references('id')->on('activity_launches');
            $table->unsignedBigInteger('tvde_operator_id')->nullable();
            $table->foreign('tvde_operator_id', 'tvde_operator_fk_8087849')->references('id')->on('tvde_operators');
        });
    }
}
