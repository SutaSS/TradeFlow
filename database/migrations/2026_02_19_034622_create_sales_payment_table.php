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
        Schema::create('sales_payment', function (Blueprint $table) {
            $table->id('payment_id');
            $table->date('payment_date');
            $table->unsignedBigInteger('sales_invoice_id');
            $table->decimal('amount_paid', 12, 2);
            $table->unsignedBigInteger('received_by');
            $table->unsignedBigInteger('paid_by');
            $table->string('status');
            $table->timestamps();
            
            $table->foreign('sales_invoice_id')->references('sales_invoice_id')->on('sales_invoice');
            $table->foreign('received_by')->references('user_id')->on('m_user');
            $table->foreign('paid_by')->references('customer_id')->on('m_customer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_payment');
    }
};
