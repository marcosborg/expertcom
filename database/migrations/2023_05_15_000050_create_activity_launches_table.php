<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLaunchesTable extends Migration
{
    public function up()
    {
        Schema::create('activity_launches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('rent', 15, 2);
            $table->decimal('management', 15, 2);
            $table->decimal('insurance', 15, 2);
            $table->decimal('fuel', 15, 2);
            $table->decimal('tolls', 15, 2);
            $table->decimal('others', 15, 2);
            $table->decimal('refund', 15, 2);
            $table->integer('initial_kilometers')->nullable();
            $table->integer('final_kilometers')->nullable();
            $table->boolean('send')->default(0)->nullable();
            $table->boolean('paid')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
