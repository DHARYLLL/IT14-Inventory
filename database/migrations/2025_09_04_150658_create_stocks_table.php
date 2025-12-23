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
            $table->mediumIncrements('id');
            $table->string('item_name', 100);
            $table->smallInteger('item_qty');
            $table->smallInteger('item_net_content');
            $table->string('item_size', 20);
            $table->string('item_type', 15);
            $table->smallInteger('item_low_limit');
            $table->boolean('archived')->nullable();

            $table->timestamps();

            $table->unique(['item_name', 'item_size', 'item_net_content'], 'stock_unique');
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
