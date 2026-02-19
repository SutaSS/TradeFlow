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
        Schema::create('goods_receipt', function (Blueprint $table) {
            $table->id('gr_id');
            $table->date('gr_date');
            $table->unsignedBigInteger('po_id');
            $table->unsignedBigInteger('received_by');
            $table->timestamps();
            
            $table->foreign('po_id')->references('po_id')->on('purchase_order');
            $table->foreign('received_by')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt');
    }
};
