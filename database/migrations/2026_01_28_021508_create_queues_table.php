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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('set null'); // Selected Healthcare Service
            $table->boolean('bpjs_usage')->default(false); // BPJS Usage (Yes / No)
            $table->integer('queue_number');
            $table->enum('status', ['waiting', 'called', 'finished', 'cancelled'])->default('waiting'); // Added 'called' and 'cancelled'
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
