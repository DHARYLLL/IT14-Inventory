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
        Schema::create('sto_out_equipment', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('so_id')->nullable();
            $table->foreign('so_id')->references('id')->on('stock_outs')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('eq_id')->nullable();
            $table->foreign('eq_id')->references('id')->on('equipments')->onUpdate('cascade');

            $table->smallInteger('so_qty');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sto_out_equipment');
    }
};
