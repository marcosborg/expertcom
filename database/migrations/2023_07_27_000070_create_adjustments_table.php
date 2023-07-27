<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentsTable extends Migration
{
    public function up()
    {
        Schema::create('adjustments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('percent')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
