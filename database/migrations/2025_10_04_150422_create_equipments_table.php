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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('eq_name', 100)->unique();
            $table->string('eq_type', 15);
            $table->smallInteger('eq_available')->nullable();
            $table->string('eq_size_weight', 20);
            $table->decimal('eq_unit_price', 8,2);
            $table->smallInteger('eq_in_use')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
