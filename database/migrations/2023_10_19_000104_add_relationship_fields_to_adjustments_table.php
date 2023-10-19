<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAdjustmentsTable extends Migration
{
    public function up()
    {
        Schema::table('adjustments', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_9127000')->references('id')->on('companies');
        });
    }
}
