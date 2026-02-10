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
        Schema::table('queues', function (Blueprint $table) {
            $table->unsignedBigInteger('user_patient_id')->nullable()->after('patient_id');
            $table->unsignedBigInteger('patient_id')->nullable()->change();

            $table->foreign('user_patient_id')->references('id')->on('user_patients')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            $table->dropForeign(['user_patient_id']);
            $table->dropColumn('user_patient_id');
            $table->unsignedBigInteger('patient_id')->nullable(false)->change();
        });
    }
};
