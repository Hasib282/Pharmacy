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
        Schema::connection('mysql')->create('employee__organization__details', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->date('joining_date');
            $table->bigInteger('joining_location');
            $table->unsignedBigInteger('department');
            $table->unsignedBigInteger('designation');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('emp_id')->references('employee_id')->on('employee__personal__details')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->foreign('department')->references('id')->on('department__infos')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->foreign('designation')->references('id')->on('designations')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('employee__joining__details');
    }
};
