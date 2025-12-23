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
        Schema::create('pkg_stock', function (Blueprint $table) {
            $table->mediumIncrements('id');

            $table->unsignedMediumInteger('pkg_id')->nullable();
            $table->foreign('pkg_id')->references('id')->on('packages')->onUpdate('cascade');

            $table->unsignedMediumInteger('prep_id')->nullable();
            $table->foreign('prep_id')->references('id')->on('embalming')->onUpdate('cascade');

            $table->unsignedMediumInteger('stock_id')->nullable();
            $table->foreign('stock_id')->references('id')->on('stocks')->onUpdate('cascade');

            $table->smallInteger('stock_used');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkg_stock');
    }
};
