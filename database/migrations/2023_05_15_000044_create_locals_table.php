<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalsTable extends Migration
{
    public function up()
    {
        Schema::create('locals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
