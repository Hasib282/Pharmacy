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
        Schema::connection('mysql_second')->create('employee__experience__details', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->string('company_name');
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('company_location')->nullable()->comment('location__infos');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('emp_id')->references('employee_id')->on('employee__personal__details')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('employee__experience__details');
    }
};
