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
        Schema::create('pkg_equipment', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pkg_id')->nullable();
            $table->foreign('pkg_id')->references('id')->on('packages')->onUpdate('cascade')->nullOnDelete();

            $table->unsignedBigInteger('prep_id')->nullable();
            $table->foreign('prep_id')->references('id')->on('embalming')->onUpdate('cascade')->nullOnDelete();

            $table->unsignedBigInteger('eq_id')->nullable();
            $table->foreign('eq_id')->references('id')->on('equipments')->onUpdate('cascade')->nullOnDelete();

            $table->smallInteger('eq_used');
            $table->smallInteger('eq_used_set');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkg_equipment');
    }
};
