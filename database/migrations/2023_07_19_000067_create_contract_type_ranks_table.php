<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractTypeRanksTable extends Migration
{
    public function up()
    {
        Schema::create('contract_type_ranks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('from', 15, 2)->nullable();
            $table->decimal('to', 15, 2)->nullable();
            $table->float('percent', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
