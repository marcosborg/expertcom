<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnCarsTable extends Migration
{
    public function up()
    {
        Schema::create('own_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->longText('text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
