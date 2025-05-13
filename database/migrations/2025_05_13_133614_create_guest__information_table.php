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
        Schema::connection('mysql_second')->create('guest__information', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('gender');
            $table->string('nationality');
            $table->string('religion');
            $table->string('nid');
            $table->string('passport');
            $table->string('driving_lisence');
            $table->string('address');
            $table->string('arrival_from');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('guest__information');
    }
};
