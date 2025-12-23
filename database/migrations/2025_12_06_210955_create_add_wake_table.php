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
        Schema::create('add_wake', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->smallInteger('day');
            $table->decimal('fee', 8,2);

            $table->unsignedMediumInteger('jod_id');
            $table->foreign('jod_id')->references('id')->on('job_ord_details')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_wake');
    }
};
