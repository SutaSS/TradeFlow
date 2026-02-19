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
        Schema::create('delivery_order', function (Blueprint $table) {
            $table->id('do_id');
            $table->unsignedBigInteger('so_id');
            $table->date('do_date');
            $table->unsignedBigInteger('delivered_by');
            $table->timestamps();
            
            $table->foreign('so_id')->references('so_id')->on('sales_order');
            $table->foreign('delivered_by')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_order');
    }
};
