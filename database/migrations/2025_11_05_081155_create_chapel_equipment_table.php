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
        Schema::create('chapel_equipment', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('chap_id');
            $table->foreign('chap_id')->references('id')->on('chapels')->onUpdate('cascade');

            $table->unsignedBigInteger('eq_id');
            $table->foreign('eq_id')->references('id')->on('equipments')->onUpdate('cascade');

            $table->smallInteger('eq_used')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapel_equipment');
    }
};
