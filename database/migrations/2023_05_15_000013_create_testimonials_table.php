<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message')->nullable();
            $table->string('name')->nullable();
            $table->string('job_position')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
