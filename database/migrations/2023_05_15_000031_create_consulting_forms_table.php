<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultingFormsTable extends Migration
{
    public function up()
    {
        Schema::create('consulting_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->longText('message')->nullable();
            $table->boolean('rgpd')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
