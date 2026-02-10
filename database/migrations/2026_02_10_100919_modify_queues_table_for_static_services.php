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
            $table->unsignedBigInteger('service_id')->nullable()->change();
            $table->string('service_name')->nullable()->after('service_id');
            // Check if payment_method exists before dropping, though based on inspection it might not.
            // But user mentioned removing payment, so if it was there we'd drop it.
            // Based on inspection of Queue model, it doesn't have payment_method, but better safe.
            if (Schema::hasColumn('queues', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('queues', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id')->nullable(false)->change();
            $table->dropColumn('service_name');
        });
    }
};
