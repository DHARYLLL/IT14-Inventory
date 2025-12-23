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
            $table->mediumIncrements('id');
            $table->string('eq_name', 100);
            $table->string('eq_type', 15);
            $table->smallInteger('eq_available');
            $table->smallInteger('eq_net_content');
            $table->string('eq_size', 20);
            $table->smallInteger('eq_in_use');
            $table->smallInteger('eq_low_limit');
            $table->boolean('archived')->nullable();

            $table->timestamps();

             $table->unique(['eq_name', 'eq_size', 'eq_net_content'], 'eq_unique');
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
