<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTvdeMonthsTable extends Migration
{
    public function up()
    {
        Schema::table('tvde_months', function (Blueprint $table) {
            $table->unsignedBigInteger('year_id')->nullable();
            $table->foreign('year_id', 'year_fk_7865644')->references('id')->on('tvde_years');
        });
    }
}
