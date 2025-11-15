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
        /*para dili ma add inif migrate fresh
        Schema::create('chapel_stocks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('chap_id');
            $table->foreign('chap_id')->references('id')->on('chapels')->onUpdate('cascade');

            $table->unsignedBigInteger('stock_id');
            $table->foreign('stock_id')->references('id')->on('stocks')->onUpdate('cascade');

            $table->smallInteger('stock_used')->nullable();

            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapel_stocks');
    }
};
