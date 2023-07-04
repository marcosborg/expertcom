<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvdeOperatorsTable extends Migration
{
    public function up()
    {
        Schema::create('tvde_operators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
