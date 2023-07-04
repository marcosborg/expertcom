<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferToursTable extends Migration
{
    public function up()
    {
        Schema::create('transfer_tours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->boolean('under_consultation')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
