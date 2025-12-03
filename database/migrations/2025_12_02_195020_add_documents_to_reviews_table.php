<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {

            if (!Schema::hasColumn('reviews', 'data_processing_agreement')) {
                $table->string('data_processing_agreement')->nullable();
            }

            if (!Schema::hasColumn('reviews', 'data_protection_impact_assessment')) {
                $table->string('data_protection_impact_assessment')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {

            if (Schema::hasColumn('reviews', 'data_processing_agreement')) {
                $table->dropColumn('data_processing_agreement');
            }

            if (Schema::hasColumn('reviews', 'data_protection_impact_assessment')) {
                $table->dropColumn('data_protection_impact_assessment');
            }

        });
    }
};
