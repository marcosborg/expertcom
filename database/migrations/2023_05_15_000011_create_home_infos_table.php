<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeInfosTable extends Migration
{
    public function up()
    {
        Schema::create('home_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->longText('text')->nullable();
            $table->string('button')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
