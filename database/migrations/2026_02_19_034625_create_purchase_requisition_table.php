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
        Schema::create('purchase_requisition', function (Blueprint $table) {
            $table->id('pr_id');
            $table->date('pr_date');
            $table->date('required_date');
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('approved_by');
            $table->string('status');
            $table->timestamps();
            
            $table->foreign('requested_by')->references('user_id')->on('m_user');
            $table->foreign('approved_by')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition');
    }
};
