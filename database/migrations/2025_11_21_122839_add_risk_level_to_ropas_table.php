<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ropas', function (Blueprint $table) {
            $table->enum('risk_level', ['Low', 'Medium', 'High', 'Critical'])
                ->nullable()
                ->default(null)
                ->after('risk_report');
        });
    }

    public function down(): void
    {
        Schema::table('ropas', function (Blueprint $table) {
            $table->dropColumn('risk_level');
        });
    }
};
