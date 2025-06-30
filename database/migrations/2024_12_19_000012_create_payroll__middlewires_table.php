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
        Schema::connection('mysql_second')->create('payroll__middlewires', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->unsignedBigInteger('head_id')->comment('transaction__heads');
            $table->float('amount');
            $table->date('date')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            //Foreignkey Decleration
            $table->foreign('emp_id')->references('user_id')->on('user__infos')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('payroll__middlewires');
    }
};
