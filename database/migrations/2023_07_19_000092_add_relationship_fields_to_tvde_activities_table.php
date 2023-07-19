<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTvdeActivitiesTable extends Migration
{
    public function up()
    {
        Schema::table('tvde_activities', function (Blueprint $table) {
            $table->unsignedBigInteger('tvde_week_id')->nullable();
            $table->foreign('tvde_week_id', 'tvde_week_fk_8769993')->references('id')->on('tvde_weeks');
            $table->unsignedBigInteger('tvde_operator_id')->nullable();
            $table->foreign('tvde_operator_id', 'tvde_operator_fk_8769994')->references('id')->on('tvde_operators');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_8769995')->references('id')->on('companies');
        });
    }
}
