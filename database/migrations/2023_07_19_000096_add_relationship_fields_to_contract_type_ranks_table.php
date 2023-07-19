<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToContractTypeRanksTable extends Migration
{
    public function up()
    {
        Schema::table('contract_type_ranks', function (Blueprint $table) {
            $table->unsignedBigInteger('contract_type_id')->nullable();
            $table->foreign('contract_type_id', 'contract_type_fk_8771235')->references('id')->on('contract_types');
        });
    }
}
