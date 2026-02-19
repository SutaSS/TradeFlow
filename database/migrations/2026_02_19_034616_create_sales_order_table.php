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
        Schema::create('sales_order', function (Blueprint $table) {
            $table->id('so_id');
            $table->date('so_date');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->unsignedBigInteger('signed_by');
            $table->string('status');
            $table->timestamps();
            
            $table->foreign('customer_id')->references('customer_id')->on('m_customer');
            $table->foreign('signed_by')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order');
    }
};
