<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('reason')->nullable();
            $table->string('phone')->nullable();
            $table->string('payment_vat')->nullable();
            $table->string('citizen_card')->nullable();
            $table->string('email')->nullable();
            $table->string('iban')->nullable();
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('driver_license')->nullable();
            $table->string('driver_vat')->nullable();
            $table->string('uber_uuid')->nullable();
            $table->string('license_plate')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
