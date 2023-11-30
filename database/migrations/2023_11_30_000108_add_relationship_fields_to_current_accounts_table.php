<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCurrentAccountsTable extends Migration
{
    public function up()
    {
        Schema::table('current_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('tvde_week_id')->nullable();
            $table->foreign('tvde_week_id', 'tvde_week_fk_9259884')->references('id')->on('tvde_weeks');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id', 'driver_fk_9259885')->references('id')->on('drivers');
        });
    }
}
