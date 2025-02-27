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
        Schema::connection('mysql_second')->create('doctor__information', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('degree')->nullable();
            $table->integer('chamber')->nullable();
            $table->string('marketing_head')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1:active, 0:Inactive');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('doctor__information');
    }
};
