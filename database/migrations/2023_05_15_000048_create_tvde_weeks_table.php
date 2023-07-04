<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvdeWeeksTable extends Migration
{
    public function up()
    {
        Schema::create('tvde_weeks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
