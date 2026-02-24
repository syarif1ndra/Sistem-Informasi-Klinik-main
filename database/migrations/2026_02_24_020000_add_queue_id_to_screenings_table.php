<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('screenings', function (Blueprint $table) {
            $table->foreignId('queue_id')->nullable()->after('patient_id')->constrained('queues')->nullOnDelete();
            $table->unique('queue_id'); // 1 screening per queue
        });
    }

    public function down(): void
    {
        Schema::table('screenings', function (Blueprint $table) {
            $table->dropForeign(['queue_id']);
            $table->dropUnique(['queue_id']);
            $table->dropColumn('queue_id');
        });
    }
};
