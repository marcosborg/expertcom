<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyParksTable extends Migration
{
    public function up()
    {
        Schema::table('company_parks', function (Blueprint $table) {
            $table->boolean('fleet_management')->default(0)->nullable();
        });
    }
}