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
        Schema::create('sales_invoice_detail', function (Blueprint $table) {
            $table->id('invoice_detail_id');
            $table->unsignedBigInteger('sales_invoice_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->decimal('price', 12, 2);
            $table->decimal('discount', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->timestamps();
            
            $table->foreign('sales_invoice_id')->references('sales_invoice_id')->on('sales_invoice');
            $table->foreign('product_id')->references('product_id')->on('m_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_detail');
    }
};
