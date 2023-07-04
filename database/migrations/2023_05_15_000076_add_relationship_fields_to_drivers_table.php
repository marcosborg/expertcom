<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDriversTable extends Migration
{
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_7854054')->references('id')->on('users');
            $table->unsignedBigInteger('card_id')->nullable();
            $table->foreign('card_id', 'card_fk_7853935')->references('id')->on('cards');
            $table->unsignedBigInteger('operation_id')->nullable();
            $table->foreign('operation_id', 'operation_fk_7853943')->references('id')->on('operations');
            $table->unsignedBigInteger('local_id')->nullable();
            $table->foreign('local_id', 'local_fk_7853962')->references('id')->on('locals');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id', 'state_fk_7854000')->references('id')->on('states');
        });
    }
}
