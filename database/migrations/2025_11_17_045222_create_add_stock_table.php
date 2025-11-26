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
        Schema::create('add_stock', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('jod_id');
            $table->foreign('jod_id')->references('id')->on('job_ord_details')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('stock_id')->nullable();
            $table->foreign('stock_id')->references('id')->on('stocks')->onUpdate('cascade')->nullOnDelete();

            $table->smallInteger('stock_dpl');
            $table->decimal('stock_add_fee', 8,2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_stock');
    }
};
