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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('pkg_name', 50)->unique();
            $table->decimal('pkg_price', 8,2);

            $table->unsignedBigInteger('svc_id')->nullable();
            $table->foreign('svc_id')->references('id')->on('services_requests')->onUpdate('cascade')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
