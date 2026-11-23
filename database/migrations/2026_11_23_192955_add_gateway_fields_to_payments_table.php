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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('gateway')->nullable()->after('method');
            $table->string('gateway_order_id')->nullable()->unique()->after('gateway');
            $table->string('gateway_transaction_id')->nullable()->after('gateway_order_id');
            $table->json('gateway_payload')->nullable()->after('gateway_transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropUnique(['gateway_order_id']);
            $table->dropColumn(['gateway', 'gateway_order_id', 'gateway_transaction_id', 'gateway_payload']);
        });
    }
};
