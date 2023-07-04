<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('company_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
