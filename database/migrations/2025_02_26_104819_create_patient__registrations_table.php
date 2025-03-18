<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mysql_second')->create('patient__registrations', function (Blueprint $table) {
            $table->id();
            $table->string('ptn_id')->nullable();
            $table->string('reg_id')->nullable();
            $table->unsignedBigInteger('bed_category')->nullable();
            $table->unsignedBigInteger('bed_list')->nullable();
            $table->unsignedBigInteger('doctor')->nullable();
            $table->string('sr_id')->nullable();
            $table->string('addmission_by')->nullable();
            $table->string('discharge_by')->nullable();
            $table->date('discharge_date')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1:active, 0:Inactive');
            $table->timestamp('added_at')->useCurrent();//admission date
            $table->timestamp('updated_at')->nullable();

            //$table->foreign('doctor')->references('id')->on('doctor__informations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('patient__registrations');
    }
};