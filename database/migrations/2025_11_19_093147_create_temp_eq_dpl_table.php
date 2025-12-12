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
        Schema::create('temp_eq_dpl', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('jod_id')->nullable();
            $table->foreign('jod_id')->references('id')->on('job_ord_details')->onUpdate('cascade')->nullOnDelete();

            $table->unsignedBigInteger('pkg_eq_id')->nullable();
            $table->foreign('pkg_eq_id')->references('id')->on('pkg_equipment')->onUpdate('cascade')->nullOnDelete();

            $table->smallInteger('eq_dpl_qty');
            $table->smallInteger('eq_dpl_qty_set');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_eq_dpl');
    }
};
