<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {

            if (!Schema::hasColumn('reviews', 'section_scores')) {
                $table->json('section_scores')
                    ->nullable()
                    ->after('score');
            }

            if (!Schema::hasColumn('reviews', 'data_processing_agreement')) {
                $table->boolean('data_processing_agreement')
                    ->default(false)
                    ->after('section_scores');
            }

            if (!Schema::hasColumn('reviews', 'data_protection_impact_assessment')) {
                $table->boolean('data_protection_impact_assessment')
                    ->default(false)
                    ->after('data_processing_agreement');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'section_scores',
                'data_processing_agreement',
                'data_protection_impact_assessment',
            ]);
        });
    }
};
