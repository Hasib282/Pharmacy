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
        Schema::connection('mysql_second')->create('attendences', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->date('date');
            $table->time('in');
            $table->time('out')->nullable();
            $table->timestamp('insert_at')->useCurrent();
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
        Schema::connection('mysql_second')->dropIfExists('attendences');
    }
};
