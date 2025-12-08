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
        Schema::create('job_ord_details', function (Blueprint $table) {
            $table->id();
            $table->string('dec_name', 100);
            $table->date('dec_born_date');
            $table->date('dec_died_date');
            $table->string('jod_days_of_wake', 3);
            $table->string('jod_burialLoc', 150)->nullable();
            $table->string('jod_eq_stat', 15);
            $table->date('jod_deploy_date')->nullable();
            $table->date('jod_return_date')->nullable();

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
        Schema::dropIfExists('job_ord_details');
    }
};
