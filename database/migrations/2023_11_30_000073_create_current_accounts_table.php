<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('current_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('data');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
