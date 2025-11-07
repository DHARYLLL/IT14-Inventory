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
            $table->string('dec_name', 100);
            $table->date('dec_born_date');
            $table->date('dec_died_date');
            $table->string('dec_cause_of_death', 100);
            $table->string('dec_mom_name', 100);
            $table->string('dec_fr_name', 100);
            $table->date('svc_startDate')->nullable();
            $table->date('svc_endDate')->nullable();
            $table->string('svc_wakeLoc', 150);
            $table->string('svc_churchLoc', 150);
            $table->string('svc_burialLoc', 150);
            $table->string('svc_equipment_status', 15);
            $table->date('svc_deploy_date')->nullable();
            $table->date('svc_return_date')->nullable();

            $table->unsignedBigInteger('pkg_id');
            $table->foreign('pkg_id')->references('id')->on('packages')->onUpdate('cascade');

            $table->unsignedBigInteger('chap_id')->nullable();
            $table->foreign('chap_id')->references('id')->on('chapels')->onUpdate('cascade');

            
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
