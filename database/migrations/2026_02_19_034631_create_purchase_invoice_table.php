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
        Schema::create('purchase_invoice', function (Blueprint $table) {
            $table->id('purchase_invoice_id');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('gr_id');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->unsignedBigInteger('signed_by');
            $table->timestamps();
            
            $table->foreign('supplier_id')->references('supplier_id')->on('m_supplier');
            $table->foreign('gr_id')->references('gr_id')->on('goods_receipt');
            $table->foreign('signed_by')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_invoice');
    }
};
