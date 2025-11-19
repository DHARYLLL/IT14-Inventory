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
            $table->string('eq_name', 100);
            $table->string('eq_type', 15);
            $table->smallInteger('eq_available');
            $table->string('eq_size', 20);
            $table->smallInteger('eq_qty_set')->nullable();
            $table->smallInteger('eq_total_qty')->nullable();
            $table->decimal('eq_unit_price', 8,2);
            $table->smallInteger('eq_in_use');

            $table->timestamps();

             $table->unique(['eq_name', 'eq_size']);
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
