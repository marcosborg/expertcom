<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvdeMonthsTable extends Migration
{
    public function up()
    {
        Schema::create('tvde_months', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('number');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
