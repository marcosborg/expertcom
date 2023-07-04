<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('button')->nullable();
            $table->string('link')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
