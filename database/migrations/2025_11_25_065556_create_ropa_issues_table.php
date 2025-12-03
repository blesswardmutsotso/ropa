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
        Schema::create('ropa_issues', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('ropa_id')
                ->constrained('ropas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('user_id')
                ->nullable()  // Keep ticket history even if employee is deleted
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // Fields
            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('risk_level', ['low', 'medium', 'high', 'critical'])
                ->default('low')
                ->index();

            $table->enum('status', ['open', 'resolved'])
                ->default('open')
                ->index();

            $table->timestamps();
            $table->softDeletes(); // (Optional but recommended)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ropa_issues');
    }
};
