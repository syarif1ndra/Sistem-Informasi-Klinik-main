<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('examined_by')->constrained('users')->onDelete('cascade');
            $table->dateTime('examined_at');
            $table->string('height')->nullable();       // cm
            $table->string('weight')->nullable();       // kg
            $table->string('blood_pressure')->nullable(); // e.g. 120/80
            $table->string('temperature')->nullable();  // °C
            $table->string('pulse')->nullable();        // bpm
            $table->string('respiratory_rate')->nullable(); // per menit
            $table->text('main_complaint')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('diagnosis_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screenings');
    }
};
