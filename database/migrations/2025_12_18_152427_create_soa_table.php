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
        Schema::create('soa', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->decimal('payment', 8,2);
            $table->date('payment_date');

            $table->unsignedMediumInteger('jo_id');
            $table->foreign('jo_id')->references('id')->on('job_orders')->onUpdate('cascade');

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
        Schema::dropIfExists('soa');
    }
};
