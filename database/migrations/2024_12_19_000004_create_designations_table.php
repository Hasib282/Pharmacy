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
        Schema::connection('mysql_second')->create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->unsignedBigInteger('dept_id');
            $table->tinyInteger('status')->default('1');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            //Foreignkey Decleration
            $table->foreign('dept_id')->references('id')->on('departments')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('designations');
    }
};
