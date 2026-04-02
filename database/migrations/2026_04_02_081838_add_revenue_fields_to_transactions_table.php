<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('medical_staff_revenue')->default(0)->after('total_amount');
            $table->integer('clinic_revenue')->default(0)->after('medical_staff_revenue');
            $table->enum('staff_payment_status', ['unpaid', 'paid'])->default('unpaid')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['medical_staff_revenue', 'clinic_revenue', 'staff_payment_status']);
        });
    }
};
