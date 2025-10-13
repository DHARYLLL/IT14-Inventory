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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('fname', 30);
            $table->string('mname', 15)->nullable();
            $table->string('lname', 15);
            $table->string('contact_number', 11);
            $table->string('company_name');
            $table->string('company_address');
            $table->timestamps();

            $table->unique(['contact_number', 'company_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
