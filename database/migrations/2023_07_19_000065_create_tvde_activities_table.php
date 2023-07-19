<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvdeActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('tvde_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('driver_code');
            $table->decimal('earnings_one', 15, 2)->nullable();
            $table->decimal('earnings_two', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
