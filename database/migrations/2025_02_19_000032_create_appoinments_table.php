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
            $table->string('appointment_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->Date('date')->nullable(); // apontment date
            $table->string('appoinment_serial')->nullable();
            $table->unsignedBigInteger('Doctor')->nullable();
            $table->string('schedule')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1:active, 0:inactive');
            $table->timestamp('added_at')->useCurrent(); // admission date
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
