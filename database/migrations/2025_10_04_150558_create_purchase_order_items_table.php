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
            $table->string('size', 20);
            $table->smallInteger('qty');
            $table->smallInteger('qty_set');
            $table->smallInteger('qty_total');
            $table->decimal('unit_price', 8,2);
            $table->decimal('total_amount', 8,2);
            $table->smallInteger('qty_arrived')->nullable();
            $table->string('type', 15);

            $table->unsignedBigInteger('po_id');
            $table->foreign('po_id')->references('id')->on('purchase_orders')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('stock_id')->nullable();
            $table->foreign('stock_id')->references('id')->on('stocks')->onUpdate('cascade')->nullOnDelete();

            $table->unsignedBigInteger('eq_id')->nullable();
            $table->foreign('eq_id')->references('id')->on('equipments')->onUpdate('cascade')->nullOnDelete();

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
