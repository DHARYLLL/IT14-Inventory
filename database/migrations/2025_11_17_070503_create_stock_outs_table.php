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
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('reason', 100);
            $table->date('so_date');
            $table->string('status',10)->nullable();

            $table->unsignedMediumInteger('emp_id');
            $table->foreign('emp_id')->references('id')->on('employees')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};
