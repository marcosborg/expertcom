<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvdeYearsTable extends Migration
{
    public function up()
    {
        Schema::create('tvde_years', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
