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
        Schema::create('add_equipment', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('jod_id');
            $table->foreign('jod_id')->references('id')->on('job_ord_details')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('eq_id')->nullable();
            $table->foreign('eq_id')->references('id')->on('equipments')->onUpdate('cascade')->nullOnDelete();

            $table->smallInteger('eq_dpl');
            $table->decimal('eq_add_fee', 8,2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_equipment');
    }
};
