<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ropas', function (Blueprint $table) {
            // Convert string columns to JSON
            $table->json('other_organisation_name')->nullable()->change();
            $table->json('other_department')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ropas', function (Blueprint $table) {
            // Revert JSON columns back to string
            $table->string('other_organisation_name')->nullable()->change();
            $table->string('other_department')->nullable()->change();
        });
    }
};
