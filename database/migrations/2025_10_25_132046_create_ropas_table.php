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
        Schema::create('ropas', function (Blueprint $table) {
            $table->id();

            // User who submitted the ROPA
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // -------------------------------
            // Section 1: Organisation Details
            // -------------------------------
            $table->string('organisation_name')->nullable();
            $table->json('other_organisation_name')->nullable(); // multiple other orgs
            $table->string('department')->nullable();
            $table->json('other_department')->nullable(); // multiple other departments

            // --------------------------------------
            // Section 2: Processing Activity Details
            // --------------------------------------
            $table->json('processes')->nullable();
            $table->json('data_sources')->nullable();
            $table->json('data_sources_other')->nullable();
            $table->json('data_formats')->nullable();
            $table->json('data_formats_other')->nullable();
            $table->json('information_nature')->nullable();
            $table->json('personal_data_categories')->nullable();
            $table->json('personal_data_categories_other')->nullable();
            $table->json('records_count')->nullable();
            $table->json('data_volume')->nullable();
            $table->json('retention_period_years')->nullable();
            $table->json('access_estimate')->nullable();
            $table->json('retention_rationale')->nullable();

            // -------------------------------
            // Section 3: Data Sharing
            // -------------------------------
            $table->boolean('information_shared')->nullable();
            $table->json('sharing_type')->nullable(); // local / transborder
            $table->json('local_organizations')->nullable();
            $table->json('transborder_countries')->nullable();
            $table->text('sharing_comment')->nullable();

            // -------------------------------
            // Section 4: Access Control
            // -------------------------------
            $table->boolean('access_control')->nullable();
            $table->json('access_measures')->nullable();
            $table->json('technical_measures')->nullable();
            $table->json('technical_measures_other')->nullable();
            $table->json('organisational_measures')->nullable();
            $table->json('organisational_measures_other')->nullable();

            // -------------------------------
            // Section 5: Lawful Basis
            // -------------------------------
            $table->json('lawful_basis')->nullable();
            $table->json('lawful_basis_other')->nullable();

            // -------------------------------
            // Section 6: Risk Reporting
            // -------------------------------
            $table->text('risk_report')->nullable();

            // -------------------------------
            // Status & Timestamps
            // -------------------------------
            $table->enum('status', ['Pending', 'Reviewed'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ropas');
    }
};
