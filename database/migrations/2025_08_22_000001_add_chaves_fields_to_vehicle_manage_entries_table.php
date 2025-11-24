<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChavesFieldsToVehicleManageEntriesTable extends Migration
{
    public function up()
    {
        Schema::table('vehicle_manage_entries', function (Blueprint $table) {
            $table->boolean('chaves_1')->default(false)->after('cinzeiro_minutos');
            $table->boolean('chaves_2')->default(false)->after('chaves_1');
        });
    }

    public function down()
    {
        Schema::table('vehicle_manage_entries', function (Blueprint $table) {
            $table->dropColumn(['chaves_1', 'chaves_2']);
        });
    }
}
