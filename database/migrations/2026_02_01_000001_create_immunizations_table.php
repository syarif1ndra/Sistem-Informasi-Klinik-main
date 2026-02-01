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
        Schema::create('immunizations', function (Blueprint $table) {
            $table->id();
            $table->string('child_name');
            $table->string('child_nik')->nullable(); // NIK is optional for babies sometimes? Requirement says "Child's NIK / Phone Number"
            $table->string('child_phone')->nullable(); // Saving both to be safe or one field
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('parent_name');
            $table->text('address');
            $table->text('notes')->nullable();
            $table->date('immunization_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('immunizations');
    }
};
