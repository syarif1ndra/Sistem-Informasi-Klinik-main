<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('patients', 'whatsapp_number')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->renameColumn('whatsapp_number', 'phone');
            });
        }

        if (!Schema::hasColumn('patients', 'phone')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->string('phone')->after('address');
            });
        }

        if (!Schema::hasColumn('patients', 'service')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->string('service')->nullable()->after('address');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('patients', 'service')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->dropColumn('service');
            });
        }

        if (Schema::hasColumn('patients', 'phone') && !Schema::hasColumn('patients', 'whatsapp_number')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->renameColumn('phone', 'whatsapp_number');
            });
        }
    }
};
