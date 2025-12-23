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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('status', 15);
            $table->decimal('total_amount', 8,2)->nullable();
            $table->date('submitted_date')->nullable();
            $table->date('approved_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->boolean('archived')->nullable();
           
            $table->unsignedMediumInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onUpdate('cascade');

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
        Schema::dropIfExists('purchase_orders');
    }
};
