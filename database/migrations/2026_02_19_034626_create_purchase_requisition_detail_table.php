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
        Schema::create('purchase_requisition_detail', function (Blueprint $table) {
            $table->id('pr_detail_id');
            $table->unsignedBigInteger('pr_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->string('description')->nullable();
            $table->timestamps();
            
            $table->foreign('pr_id')->references('pr_id')->on('purchase_requisition');
            $table->foreign('product_id')->references('product_id')->on('m_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition_detail');
    }
};
