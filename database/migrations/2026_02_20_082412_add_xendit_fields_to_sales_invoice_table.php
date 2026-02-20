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
        Schema::table('sales_invoice', function (Blueprint $table) {
            $table->string('xendit_invoice_id')->nullable()->after('status');
            $table->string('payment_status')->default('unpaid')->after('xendit_invoice_id'); // unpaid, paid, expired
            $table->text('payment_url')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_invoice', function (Blueprint $table) {
            $table->dropColumn(['xendit_invoice_id', 'payment_status', 'payment_url']);
        });
    }
};
