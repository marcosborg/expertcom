<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTransferFormsTable extends Migration
{
    public function up()
    {
        Schema::table('transfer_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('transfer_tour_id')->nullable();
            $table->foreign('transfer_tour_id', 'transfer_tour_fk_7757915')->references('id')->on('transfer_tours');
        });
    }
}
