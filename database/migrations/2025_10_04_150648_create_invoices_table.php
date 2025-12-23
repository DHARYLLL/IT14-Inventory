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
        Schema::create('invoices', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('invoice_number', 50)->nullable();
            $table->date('invoice_date')->nullable();
            $table->decimal('total', 8,2);

            $table->unsignedMediumInteger('po_id')->nullable();
            $table->foreign('po_id')->references('id')->on('purchase_orders')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
