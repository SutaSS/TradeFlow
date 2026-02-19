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
        Schema::create('sales_return_detail', function (Blueprint $table) {
            $table->id('return_detail_id');
            $table->unsignedBigInteger('return_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->decimal('price', 12, 2);
            $table->decimal('discount', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->timestamps();
            
            $table->foreign('return_id')->references('return_id')->on('sales_return');
            $table->foreign('product_id')->references('product_id')->on('m_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_return_detail');
    }
};
