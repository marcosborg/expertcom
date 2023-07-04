<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultingsTable extends Migration
{
    public function up()
    {
        Schema::create('consultings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->longText('text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
