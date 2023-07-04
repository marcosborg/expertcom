<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longText('specifications')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
