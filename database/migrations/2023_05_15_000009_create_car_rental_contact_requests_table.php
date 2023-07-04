<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarRentalContactRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('car_rental_contact_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('city');
            $table->boolean('tvde')->default(0)->nullable();
            $table->string('tvde_card')->nullable();
            $table->longText('message');
            $table->boolean('rgpd')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
