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
        Schema::create('embalming', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('embalmer_name', 50);
            $table->decimal('prep_price', 8,2);
            $table->boolean('archived')->nullable();
            
            $table->timestamps();

            $table->unique('embalmer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embalming');
    }
};
