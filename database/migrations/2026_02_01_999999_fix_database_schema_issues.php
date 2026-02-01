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
        Schema::table('patients', function (Blueprint $table) {
            $table->string('nik')->nullable()->change();
        });

        Schema::table('birth_records', function (Blueprint $table) {
            $table->decimal('baby_weight', 8, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // We cannot easily revert nullability if there are existing nulls, but we can try
            // assuming no nulls were added or we accept risk in down migration.
            // For safety in dev, we might leave it or try to revert.
            $table->string('nik')->nullable(false)->change();
        });

        Schema::table('birth_records', function (Blueprint $table) {
            $table->decimal('baby_weight', 5, 2)->nullable()->change();
        });
    }
};
