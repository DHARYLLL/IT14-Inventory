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
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();
            $table->string('client_name', 100);
            $table->string('client_contact_number', 11);     
            $table->decimal('jo_dp', 8,2);
            $table->decimal('jo_total', 8,2);
            $table->string('jo_status', 15);
            $table->date('jo_start_date');
            
            $table->unsignedBigInteger('emp_id')->nullable();
            $table->foreign('emp_id')->references('id')->on('employees')->onUpdate('cascade')->nullOnDelete();

            $table->unsignedBigInteger('jod_id');
            $table->foreign('jod_id')->references('id')->on('job_ord_details')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('svc_id')->nullable();
            $table->foreign('svc_id')->references('id')->on('services_requests')->onUpdate('cascade')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_orders');
    }
};
