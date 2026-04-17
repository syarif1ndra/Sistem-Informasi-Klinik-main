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
        Schema::table('birth_records', function (Blueprint $table) {
            if (!Schema::hasColumn('birth_records', 'mother_age')) {
                $table->unsignedTinyInteger('mother_age')->nullable()->after('mother_nik');
            }
            if (!Schema::hasColumn('birth_records', 'mother_job')) {
                $table->string('mother_job')->nullable()->after('mother_age');
            }
            if (!Schema::hasColumn('birth_records', 'father_age')) {
                $table->unsignedTinyInteger('father_age')->nullable()->after('father_nik');
            }
            if (!Schema::hasColumn('birth_records', 'father_job')) {
                $table->string('father_job')->nullable()->after('father_age');
            }
            if (!Schema::hasColumn('birth_records', 'child_order')) {
                $table->unsignedTinyInteger('child_order')->nullable()->after('phone_number');
            }
            if (!Schema::hasColumn('birth_records', 'attendant_name')) {
                $table->string('attendant_name')->nullable()->after('child_order');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('birth_records', function (Blueprint $table) {
            if (Schema::hasColumn('birth_records', 'attendant_name')) {
                $table->dropColumn('attendant_name');
            }
            if (Schema::hasColumn('birth_records', 'child_order')) {
                $table->dropColumn('child_order');
            }
            if (Schema::hasColumn('birth_records', 'father_job')) {
                $table->dropColumn('father_job');
            }
            if (Schema::hasColumn('birth_records', 'father_age')) {
                $table->dropColumn('father_age');
            }
            if (Schema::hasColumn('birth_records', 'mother_job')) {
                $table->dropColumn('mother_job');
            }
            if (Schema::hasColumn('birth_records', 'mother_age')) {
                $table->dropColumn('mother_age');
            }
        });
    }
};
