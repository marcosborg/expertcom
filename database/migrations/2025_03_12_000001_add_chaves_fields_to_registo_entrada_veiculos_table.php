<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registo_entrada_veiculos', function (Blueprint $table) {
            $table->boolean('chaves_1')->default(false)->after('cinzeiro_nada_consta');
            $table->boolean('chaves_2')->default(false)->after('chaves_1');
        });
    }

    public function down(): void
    {
        Schema::table('registo_entrada_veiculos', function (Blueprint $table) {
            $table->dropColumn(['chaves_1', 'chaves_2']);
        });
    }
};
