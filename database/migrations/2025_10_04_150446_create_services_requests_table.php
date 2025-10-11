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
        Schema::create('services_requests', function (Blueprint $table) {
            $table->id();
            $table->string('client_name', 100);
            $table->string('client_contact_number', 11);
            $table->date('svc_startDate')->nullable();
            $table->date('svc_endDate')->nullable();
            $table->string('svc_wakeLoc', 150);
            $table->string('svc_churchLoc', 150);
            $table->string('svc_burialLoc', 150);
            $table->string('svc_equipment_status', 15);
            $table->date('svc_return_Date')->nullable();

            $table->unsignedBigInteger('package_id')->nullable();
            $table->foreign('package_id')->references('id')->on('packages')->onUpdate('cascade');
            $table->unsignedBigInteger('emp_id')->nullable();
            $table->foreign('emp_id')->references('id')->on('employees')->onUpdate('cascade')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_requests');
    }
};
