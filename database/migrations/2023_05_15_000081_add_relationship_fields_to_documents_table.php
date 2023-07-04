<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDocumentsTable extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id', 'driver_fk_8191733')->references('id')->on('drivers');
        });
    }
}
