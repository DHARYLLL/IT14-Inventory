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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->string('item', 100);
            $table->smallInteger('qty');
            $table->string('sizeWeight', 20);
            $table->decimal('unit_price', 5,2);
            $table->decimal('total_amount', 8,2);

            $table->unsignedBigInteger('po_id')->nullable();
            $table->foreign('po_id')->references('id')->on('purchase_orders')->onUpdate('cascade')->nullOnDelete();

            $table->unsignedBigInteger('stock_id')->nullable();
            $table->foreign('stock_id')->references('id')->on('stocks')->onUpdate('cascade')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
