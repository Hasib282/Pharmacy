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
        Schema::connection('mysql_second')->create('login__users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->unsignedBigInteger('user_role');
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->string('company_id')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1 for Active 0 for Inactive');
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Foreignkey Decleration 
            $table->foreign('user_role')->references('id')->on('roles')
                ->onUpdate('cascade');
            $table->foreign('company_id')->references('company_id')->on('company__details')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('login__users');
    }
};
