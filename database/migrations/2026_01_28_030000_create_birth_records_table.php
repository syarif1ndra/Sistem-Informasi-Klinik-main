<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('birth_records', function (Blueprint $table) {
            $table->id();
            $table->string('baby_name');
            $table->date('birth_date');
            $table->time('birth_time');
            $table->string('birth_place');
            $table->enum('gender', ['L', 'P']);
            $table->string('mother_name');
            $table->string('mother_nik');
            $table->string('father_name');
            $table->string('father_nik');
            $table->string('mother_address')->nullable();
            $table->string('father_address')->nullable();
            $table->string('phone_number')->nullable(); // Added

            // Medical Data
            $table->string('gpa')->nullable(); // G P A
            $table->text('kala_1')->nullable();
            $table->text('kala_2')->nullable();
            $table->text('kala_3')->nullable();

            // Anthropometry
            $table->decimal('baby_weight', 8, 2)->nullable(); // Changed to allow grams (e.g. 3000.00)
            $table->decimal('baby_length', 5, 2)->nullable();
            $table->decimal('head_circumference', 5, 2)->nullable(); // Added
            $table->decimal('chest_circumference', 5, 2)->nullable(); // Added

            $table->string('birth_certificate_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birth_records');
    }
};
