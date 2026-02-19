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
        Schema::create('purchase_payment', function (Blueprint $table) {
            $table->id('payment_id');
            $table->date('payment_date');
            $table->unsignedBigInteger('purchase_invoice_id');
            $table->decimal('amount_paid', 12, 2);
            $table->unsignedBigInteger('paid_by');
            $table->unsignedBigInteger('received_by');
            $table->string('status');
            $table->timestamps();
            
            $table->foreign('purchase_invoice_id')->references('purchase_invoice_id')->on('purchase_invoice');
            $table->foreign('paid_by')->references('user_id')->on('m_user');
            $table->foreign('received_by')->references('supplier_id')->on('m_supplier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_payment');
    }
};
