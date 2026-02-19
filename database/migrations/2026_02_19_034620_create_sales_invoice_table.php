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
        Schema::create('sales_invoice', function (Blueprint $table) {
            $table->id('sales_invoice_id');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('so_id');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->unsignedBigInteger('signed_by');
            $table->string('status');
            $table->timestamps();
            
            $table->foreign('customer_id')->references('customer_id')->on('m_customer');
            $table->foreign('so_id')->references('so_id')->on('sales_order');
            $table->foreign('signed_by')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice');
    }
};
