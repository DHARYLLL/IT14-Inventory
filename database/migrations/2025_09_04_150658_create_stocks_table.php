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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('item_name', 100)->unique();
            $table->smallInteger('item_qty');
            $table->string('item_size', 20);
            $table->decimal('item_unit_price', 8,2);
            $table->smallInteger('item_qty_set')->nullable();
            $table->smallInteger('item_total_qty')->nullable();
            $table->string('item_type', 15);

            $table->timestamps();

            $table->unique(['item_name', 'item_size']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
