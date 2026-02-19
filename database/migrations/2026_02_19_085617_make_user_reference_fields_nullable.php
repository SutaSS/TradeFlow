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
        // Drop FK constraints and make user-reference fields nullable
        Schema::table('sales_order', function (Blueprint $table) {
            $table->dropForeign(['signed_by']);
            $table->unsignedBigInteger('signed_by')->nullable()->change();
        });

        Schema::table('delivery_order', function (Blueprint $table) {
            $table->dropForeign(['delivered_by']);
            $table->unsignedBigInteger('delivered_by')->nullable()->change();
        });

        Schema::table('sales_invoice', function (Blueprint $table) {
            $table->dropForeign(['signed_by']);
            $table->unsignedBigInteger('signed_by')->nullable()->change();
        });

        Schema::table('sales_payment', function (Blueprint $table) {
            $table->dropForeign(['received_by']);
            $table->dropForeign(['paid_by']);
            $table->unsignedBigInteger('received_by')->nullable()->change();
            $table->unsignedBigInteger('paid_by')->nullable()->change();
        });

        Schema::table('sales_return', function (Blueprint $table) {
            $table->dropForeign(['signed_by']);
            $table->unsignedBigInteger('signed_by')->nullable()->change();
        });

        Schema::table('purchase_requisition', function (Blueprint $table) {
            $table->dropForeign(['requested_by']);
            $table->dropForeign(['approved_by']);
            $table->unsignedBigInteger('requested_by')->nullable()->change();
            $table->unsignedBigInteger('approved_by')->nullable()->change();
        });

        Schema::table('purchase_order', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->unsignedBigInteger('approved_by')->nullable()->change();
        });

        Schema::table('goods_receipt', function (Blueprint $table) {
            $table->dropForeign(['received_by']);
            $table->unsignedBigInteger('received_by')->nullable()->change();
        });

        Schema::table('purchase_invoice', function (Blueprint $table) {
            $table->dropForeign(['signed_by']);
            $table->unsignedBigInteger('signed_by')->nullable()->change();
        });

        Schema::table('purchase_payment', function (Blueprint $table) {
            $table->dropForeign(['paid_by']);
            $table->dropForeign(['received_by']);
            $table->unsignedBigInteger('paid_by')->nullable()->change();
            $table->unsignedBigInteger('received_by')->nullable()->change();
        });

        Schema::table('purchase_return', function (Blueprint $table) {
            $table->dropForeign(['signed_by']);
            $table->unsignedBigInteger('signed_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: FK restoration not needed for rollback in dev environment
    }
};
