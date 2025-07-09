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
        Schema::connection('mysql')->create('permission__heads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_mainhead');
            $table->string('name');
            $table->tinyInteger('status')->default('1');
            $table->timestamp('created_at')->nullable();

            $table->foreign('permission_mainhead')->references('id')->on('permission__main__heads')
                     ->cascadeOnUpdate()
                     ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('permission__heads');
    }
};
