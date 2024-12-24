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
        Schema::connection('mysql_second')->create('user__infos', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('login_user_id')->nullable()->comment('login__users');
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('gender')->nullable();
            $table->bigInteger('loc_id')->nullable()->comment('locations');
            $table->bigInteger('user_role')->comment('roles');
            $table->unsignedBigInteger('tran_user_type')->nullable();
            $table->date('dob')->nullable();
            $table->string('nid')->nullable();
            $table->string('address')->nullable();
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1 for Active 0 for Inactive');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            // Foreignkey Decleration
            $table->foreign('tran_user_type')->references('id')->on('transaction__withs')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('user__infos');
    }
};
