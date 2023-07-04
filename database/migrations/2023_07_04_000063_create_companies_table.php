<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('vat');
            $table->string('address');
            $table->string('zip');
            $table->string('location');
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
