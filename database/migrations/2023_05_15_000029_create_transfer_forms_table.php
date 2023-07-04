<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferFormsTable extends Migration
{
    public function up()
    {
        Schema::create('transfer_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->boolean('rgpd')->default(0);
            $table->longText('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
