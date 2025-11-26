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
        Schema::create('burial_assistance', function (Blueprint $table) {
            $table->id();
            $table->string('civil_status',20);
            $table->string('religion', 50);
            $table->string('address', 150);
            $table->date('birthdate');
            $table->string('gender', 10);
            $table->string('rel_to_the_dec', 50);
            $table->decimal('amount', 8,2);

            $table->unsignedBigInteger('jo_id')->nullable();
            $table->foreign('jo_id')->references('id')->on('job_orders')->onUpdate('cascade')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('burial_assistance');
    }
};
