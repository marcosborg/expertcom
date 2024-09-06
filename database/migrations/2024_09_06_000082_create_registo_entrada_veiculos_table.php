<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistoEntradaVeiculosTable extends Migration
{
    public function up()
    {
        Schema::table('registo_entrada_veiculos', function (Blueprint $table) {
            $table->longText('signature_collector_data')->nullable();
            $table->longText('signature_driver_data')->nullable();
        });
    }
}