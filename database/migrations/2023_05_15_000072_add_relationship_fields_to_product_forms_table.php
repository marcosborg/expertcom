<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProductFormsTable extends Migration
{
    public function up()
    {
        Schema::table('product_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id', 'product_fk_7757917')->references('id')->on('products');
        });
    }
}
