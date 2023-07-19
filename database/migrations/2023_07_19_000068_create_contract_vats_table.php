<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractVatsTable extends Migration
{
    public function up()
    {
        Schema::create('contract_vats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->float('percent', 15, 2);
            $table->float('tips', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
