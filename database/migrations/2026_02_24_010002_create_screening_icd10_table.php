<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('screening_icd10', function (Blueprint $table) {
            $table->foreignId('screening_id')->constrained('screenings')->onDelete('cascade');
            $table->foreignId('icd10_code_id')->constrained('icd10_codes')->onDelete('cascade');
            $table->primary(['screening_id', 'icd10_code_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screening_icd10');
    }
};
