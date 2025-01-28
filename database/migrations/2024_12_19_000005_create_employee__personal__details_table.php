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
        Schema::connection('mysql_second')->create('employee__personal__details', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender');
            $table->string('religion');
            $table->string('marital_status');
            $table->string('nationality')->nullable();
            $table->string('nid_no')->nullable();
            $table->string('phn_no');
            $table->string('blood_group')->nullable();
            $table->string('email');
            $table->bigInteger('location_id');
            $table->unsignedBigInteger('tran_user_type');
            $table->text('address')->nullable();
            $table->binary('image')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('tran_user_type')->references('id')->on('transaction__withs')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->foreign('employee_id')->references('user_id')->on('user__infos')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('employee__personal__details');
    }
};
