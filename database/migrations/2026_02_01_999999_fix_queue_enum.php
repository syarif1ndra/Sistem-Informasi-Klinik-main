<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Using raw SQL to modify ENUM is often more reliable for this specific change in MySQL
        DB::statement("ALTER TABLE queues MODIFY COLUMN status ENUM('waiting', 'calling', 'called', 'finished', 'cancelled') NOT NULL DEFAULT 'waiting'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE queues MODIFY COLUMN status ENUM('waiting', 'called', 'finished', 'cancelled') NOT NULL DEFAULT 'waiting'");
    }
};
