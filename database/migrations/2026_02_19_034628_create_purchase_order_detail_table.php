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
        Schema::create('purchase_order_detail', function (Blueprint $table) {
            $table->id('po_detail_id');
            $table->unsignedBigInteger('po_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->decimal('price', 12, 2);
            $table->decimal('discount', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->timestamps();
            
            $table->foreign('po_id')->references('po_id')->on('purchase_order');
            $table->foreign('product_id')->references('product_id')->on('m_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_detail');
    }
};
