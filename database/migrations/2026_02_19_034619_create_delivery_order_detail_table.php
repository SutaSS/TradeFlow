<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_order_detail', function (Blueprint $table) {
            $table->id('do_detail_id');
            $table->unsignedBigInteger('do_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty_delivered');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('do_id')->references('do_id')->on('delivery_order');
            $table->foreign('product_id')->references('product_id')->on('m_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_order_detail');
    }
};
