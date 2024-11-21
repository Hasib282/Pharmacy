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
        Schema::create('employee__personal__details', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('religion');
            $table->string('marital_status');
            $table->string('nationality')->nullable();
            $table->string('nid_no')->nullable();
            $table->string('phn_no');
            $table->string('blood_group')->nullable();
            $table->string('email');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('tran_user_type');
            $table->text('address')->nullable();
            $table->binary('image')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1 for Active 0 for Inactive');
            $table->string('company_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('location_id')->references('id')->on('location__infos')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->foreign('tran_user_type')->references('id')->on('transaction__withs')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->foreign('company_id')->references('company_id')->on('company__details')
                    ->onUpdate('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee__personal__details');
    }
};
