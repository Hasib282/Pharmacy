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
        Schema::connection('mysql')->create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->unsignedBigInteger('loc_id')->nullable();
            $table->string('address')->nullable();
            $table->string('logo')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            // Foreignkey Decleration 
            $table->foreign('loc_id')->references('id')->on('location__infos')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('banks');
    }
};
