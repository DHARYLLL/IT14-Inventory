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
        Schema::create('ba_client_infos', function (Blueprint $table) {
            $table->id();

            $table->string('cli_fname',50);
            $table->string('cli_mname', 20);
            $table->string('cli_lname', 20);
            $table->string('civil_status',20);
            $table->string('religion', 50);
            $table->string('address', 150);
            $table->date('birthdate');
            $table->string('gender', 10);
            $table->string('rel_to_the_dec', 50);

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
        Schema::dropIfExists('ba_client_infos');
    }
};
