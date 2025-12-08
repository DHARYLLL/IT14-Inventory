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
        /*
        Schema::create('add_fees', function (Blueprint $table) {
            $table->id();
            $table->string('fee_name', 50)->unique();
            $table->decimal('fee_price', 8,2);

            $table->unsignedBigInteger('jo_id')->nullable();
            $table->foreign('jo_id')->references('id')->on('job_orders')->onUpdate('cascade');
            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_fees');
    }
};
