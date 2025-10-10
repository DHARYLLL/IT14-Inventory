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
            $table->string('item_name', 100);
            $table->smallInteger('item_qty')->nullable();
            $table->string('size_weight', 20);
            $table->decimal('item_unit_price', 8,2);
            $table->timestamps();

            $table->unique(['item_name', 'size_weight']);
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
