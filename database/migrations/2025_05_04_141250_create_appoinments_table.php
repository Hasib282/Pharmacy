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
        Schema::connection('mysql_second')->create('appoinments', function (Blueprint $table) {
            $table->id();
            $table->string('ptn_id');
            $table->string('name');
            $table->string('mobile');
            $table->string('appoinment_serial');
            $table->Date('date');
            $table->string('Doctor');
            $table->string('schedule');
            $table->timestamp('added_at')->useCurrent();//admission date
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('appoinments');
    }
};
