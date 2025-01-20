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
        Schema::connection('mysql')->create('company__details', function (Blueprint $table) {
            $table->id();
            $table->string('company_id')->unique();
            $table->string('company_name')->nullable();
            $table->string('company_email')->unique()->nullable();
            $table->string('company_phone')->unique()->nullable();
            $table->unsignedBigInteger('company_type')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1 for Active 0 for Inactive');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Foreignkey Decleration 
            $table->foreign('company_type')->references('id')->on('company__types')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('company__details');
    }
};
