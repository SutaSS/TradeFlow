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
        Schema::create('goods_receipt_detail', function (Blueprint $table) {
            $table->id('gr_detail_id');
            $table->unsignedBigInteger('gr_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty_received');
            $table->string('item_condition');
            $table->string('description')->nullable();
            $table->timestamps();
            
            $table->foreign('gr_id')->references('gr_id')->on('goods_receipt');
            $table->foreign('product_id')->references('product_id')->on('m_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_detail');
    }
};
