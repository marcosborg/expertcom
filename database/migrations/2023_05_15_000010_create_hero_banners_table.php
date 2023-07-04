<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroBannersTable extends Migration
{
    public function up()
    {
        Schema::create('hero_banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('button')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
