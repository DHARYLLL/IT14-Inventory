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
        Schema::create('logs', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('transaction', 50);
            $table->string('tx_desc', 50);
            $table->timestamp('tx_date', 0);

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
        Schema::dropIfExists('logs');
    }
};
