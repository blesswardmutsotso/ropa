<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {

            // Add Data Processing Agreement column
            $table->boolean('data_processing_agreement')
                ->default(false)
                ->after('score')
                ->comment('If a Data Processing Agreement exists');

            // Add DPIA column
            $table->boolean('data_protection_impact_assessment')
                ->default(false)
                ->after('data_processing_agreement')
                ->comment('If a DPIA has been completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'data_processing_agreement',
                'data_protection_impact_assessment',
            ]);
        });
    }
};
