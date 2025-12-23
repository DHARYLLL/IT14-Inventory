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
        Schema::create('chapels', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('chap_name', 50);
            $table->string('chap_room', 10);
            $table->decimal('chap_price', 8,2);  
            $table->boolean('archived')->nullable();

            $table->timestamps();

            $table->unique(['chap_name', 'chap_room']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapels');
    }
};
