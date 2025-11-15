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
        /* para dili ma add inif migrate fresh
        Schema::create('chapel_inclusions', function (Blueprint $table) {
            $table->id();
            $table->string('chap_incl_name', 50);

            $table->unsignedBigInteger('chap_id');
            $table->foreign('chap_id')->references('id')->on('chapels')->onUpdate('cascade');

            $table->timestamps();

            $table->unique(['chap_id', 'chap_incl_name']);
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapel_inclusions');
    }
};
