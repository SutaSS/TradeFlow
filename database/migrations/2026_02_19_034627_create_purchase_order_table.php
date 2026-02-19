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
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id('po_id');
            $table->unsignedBigInteger('pr_id');
            $table->date('po_date');
            $table->date('required_date');
            $table->unsignedBigInteger('supplier_id');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->unsignedBigInteger('approved_by');
            $table->string('status');
            $table->timestamps();
            
            $table->foreign('pr_id')->references('pr_id')->on('purchase_requisition');
            $table->foreign('supplier_id')->references('supplier_id')->on('m_supplier');
            $table->foreign('approved_by')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order');
    }
};
