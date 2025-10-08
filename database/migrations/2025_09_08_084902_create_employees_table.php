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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_fname', 30);
            $table->string('emp_mname', 15);
            $table->string('emp_lname', 15);
            $table->string('emp_contact_number', 11);
            $table->string('emp_address', 150);
            $table->string('emp_email', 50);
            $table->string('emp_password', 50);
            $table->string('emp_role', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
