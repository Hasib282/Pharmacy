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
        Schema::connection('mysql_second')->create('employee__education__details', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->string('degree');
            $table->string('group')->nullable();
            $table->string('institution');
            $table->string('result')->nullable();
            $table->decimal('scale')->nullable();
            $table->decimal('cgpa')->nullable();
            $table->decimal('marks')->nullable();
            $table->integer('batch');
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
        Schema::connection('mysql_second')->dropIfExists('employee__education__details');
    }
};
