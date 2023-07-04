<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTvdeWeeksTable extends Migration
{
    public function up()
    {
        Schema::table('tvde_weeks', function (Blueprint $table) {
            $table->unsignedBigInteger('tvde_month_id')->nullable();
            $table->foreign('tvde_month_id', 'tvde_month_fk_7865759')->references('id')->on('tvde_months');
        });
    }
}
