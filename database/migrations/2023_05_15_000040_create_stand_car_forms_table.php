<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandCarFormsTable extends Migration
{
    public function up()
    {
        Schema::create('stand_car_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('city');
            $table->longText('message');
            $table->boolean('rgpd')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
