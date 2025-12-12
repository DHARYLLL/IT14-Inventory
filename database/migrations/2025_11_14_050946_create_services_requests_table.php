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
        Schema::create('services_requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('veh_id')->nullable();
            $table->foreign('veh_id')->references('id')->on('vehicles')->onUpdate('cascade')->nullOnDelete();

            $table->unsignedBigInteger('prep_id')->nullable();
            $table->foreign('prep_id')->references('id')->on('embalming')->onUpdate('cascade')->nullOnDelete();

            $table->string('svc_status', 15);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_requests');
    }
};
