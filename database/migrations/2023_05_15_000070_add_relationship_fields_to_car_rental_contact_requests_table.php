<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCarRentalContactRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('car_rental_contact_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->nullable();
            $table->foreign('car_id', 'car_fk_7672090')->references('id')->on('cars');
        });
    }
}
