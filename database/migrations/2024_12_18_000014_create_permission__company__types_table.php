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
        Schema::connection('mysql')->create('permission__company__types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_type_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            $table->foreign('permission_id')->references('id')->on('permission__heads')
                     ->cascadeOnUpdate()
                     ->cascadeOnDelete();
            $table->foreign('company_type_id')->references('id')->on('company__types')
                     ->cascadeOnUpdate()
                     ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('permission__company__types');
    }
};
