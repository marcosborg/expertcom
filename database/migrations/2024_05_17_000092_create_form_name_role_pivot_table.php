<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormNameRolePivotTable extends Migration
{
    public function up()
    {
        Schema::table('form_name_role', function (Blueprint $table) {
            $table->unsignedBigInteger('form_name_id');
            $table->foreign('form_name_id', 'form_name_id_fk_9795878')->references('id')->on('form_names')->onDelete('cascade');
        });
    }
}