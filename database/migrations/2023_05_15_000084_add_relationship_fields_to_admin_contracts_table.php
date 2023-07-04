<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAdminContractsTable extends Migration
{
    public function up()
    {
        Schema::table('admin_contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id', 'driver_fk_8375591')->references('id')->on('drivers');
        });
    }
}
