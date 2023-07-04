<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityPerOperatorsTable extends Migration
{
    public function up()
    {
        Schema::create('activity_per_operators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('gross', 15, 2)->nullable();
            $table->decimal('net', 15, 2)->nullable();
            $table->decimal('taxes', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
