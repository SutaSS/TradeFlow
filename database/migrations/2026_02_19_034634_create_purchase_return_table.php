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
        Schema::create('purchase_return', function (Blueprint $table) {
            $table->id('return_id');
            $table->date('return_date');
            $table->unsignedBigInteger('purchase_invoice_id');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->unsignedBigInteger('signed_by');
            $table->timestamps();
            
            $table->foreign('purchase_invoice_id')->references('purchase_invoice_id')->on('purchase_invoice');
            $table->foreign('signed_by')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_return');
    }
};
