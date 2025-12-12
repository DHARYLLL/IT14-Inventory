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
        Schema::create('ba_mother_infos', function (Blueprint $table) {
            $table->id();

            $table->string('fname',50);
            $table->string('mname', 20);
            $table->string('lname', 20);
            $table->string('civil_status',20);
            $table->string('religion', 50);

            $table->unsignedBigInteger('ba_id');
            $table->foreign('ba_id')->references('id')->on('burial_assistance')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ba_mother_infos');
    }
};
