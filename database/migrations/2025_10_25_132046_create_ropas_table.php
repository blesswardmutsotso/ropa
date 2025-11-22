<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ropas', function (Blueprint $table) {
            $table->id();


            $table->foreignId('user_id')->constrained()->onDelete('cascade');

           // SECTION 1: Organisation Details
            $table->string('organisation_name')->nullable();
            $table->string('other_organisation_name')->nullable();
            $table->string('department')->nullable();
            $table->string('other_department')->nullable();

            // SECTION 2: Processing Activity (dynamic arrays stored as JSON)
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

            // SECTION 3: Data Sharing & Outsourcing
            $table->boolean('information_shared')->nullable();
            $table->boolean('sharing_local')->nullable();
            $table->boolean('sharing_transborder')->nullable();
            $table->json('local_organizations')->nullable();
            $table->json('transborder_countries')->nullable();
            $table->text('sharing_comment')->nullable();

            // Access Control Management
            $table->boolean('access_control')->nullable();
            $table->json('access_measures')->nullable();
            $table->json('technical_measures')->nullable();
            $table->json('organisational_measures')->nullable();

            // Lawful Basis
            $table->json('lawful_basis')->nullable();

            // SECTION 8: Risk Reporting & Mitigation
            $table->json('risk_report')->nullable();


            $table->enum('status', ['Pending', 'Reviewed'])->default('Pending');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ropas');
    }
};
