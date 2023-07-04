<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->longText('text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
