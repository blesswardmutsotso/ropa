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
        Schema::create('risk_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ropa_id')->constrained()->onDelete('cascade');
            $table->integer('risk_level')->nullable(); // 1–5 numeric score
            $table->string('category')->nullable(); // e.g. Low, Medium, High
            $table->text('factors_considered')->nullable(); // notes or description
            $table->string('assessed_by')->nullable(); // user who assessed
            $table->date('assessment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_scores');
    }
};
