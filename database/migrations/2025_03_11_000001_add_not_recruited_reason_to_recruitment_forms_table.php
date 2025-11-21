<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recruitment_forms', function (Blueprint $table) {
            $table->string('not_recruited_reason')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('recruitment_forms', function (Blueprint $table) {
            $table->dropColumn('not_recruited_reason');
        });
    }
};
