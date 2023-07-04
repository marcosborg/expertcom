<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourierFormsTable extends Migration
{
    public function up()
    {
        Schema::create('courier_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->boolean('courier')->default(0)->nullable();
            $table->string('account')->nullable();
            $table->boolean('rgpd')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
