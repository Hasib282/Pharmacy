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
        Schema::connection('mysql_second')->create('patient__registrations', function (Blueprint $table) {
            $table->id();
            $table->string('pid')->nullable();
            $table->string('rid')->nullable();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->integer('age')->nullable();// Store age as "4 years, 9 months, 23 days"
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('doctor')->nullable();
            $table->string('sr')->nullable();
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
        Schema::connection('mysql_second')->dropIfExists('patient__registrations');
    }
};
