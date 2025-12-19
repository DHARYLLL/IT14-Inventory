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
            $table->id();
            $table->decimal('payment', 8,2);
            $table->date('payment_date');

            $table->unsignedBigInteger('jo_id')->nullable();
            $table->foreign('jo_id')->references('id')->on('job_orders')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('emp_id')->nullable();
            $table->foreign('emp_id')->references('id')->on('employees')->onUpdate('cascade')->nullOnDelete();

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
