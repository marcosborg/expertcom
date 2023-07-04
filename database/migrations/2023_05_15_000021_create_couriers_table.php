<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouriersTable extends Migration
{
    public function up()
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->longText('text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
