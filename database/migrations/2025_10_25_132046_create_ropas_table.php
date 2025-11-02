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
             $table->foreignId('user_id')
                  ->constrained() 
                  ->onDelete('cascade'); 
            $table->string('status')->nullable();
            $table->timestamp('date_submitted')->nullable();
            $table->string('other_specify')->nullable();
            $table->string('information_shared')->nullable();
            $table->text('information_nature')->nullable();
            $table->string('outsourced_processing')->nullable();
            $table->string('processor')->nullable();
            $table->string('transborder_processing')->nullable();
            $table->string('country')->nullable();
            $table->text('lawful_basis')->nullable();
            $table->integer('retention_period_years')->nullable();
            $table->text('retention_rationale')->nullable();
            $table->integer('users_count')->nullable();
            $table->text('access_control')->nullable();
            $table->string('personal_data_category')->nullable();
            $table->string('organisation_name')->nullable();
            $table->string('department_name')->nullable();
            $table->string('other_department')->nullable();
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
