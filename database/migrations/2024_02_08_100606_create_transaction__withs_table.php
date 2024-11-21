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
        Schema::create('transaction__withs', function (Blueprint $table) {
            $table->id();
            $table->string('tran_with_name');
            $table->unsignedBigInteger('user_role');
            $table->unsignedBigInteger('tran_type');
            $table->string('tran_method');
            $table->string('company_id')->nullable();
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            //Foreignkey Decleration
            $table->foreign('user_role')->references('id')->on('roles')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('tran_type')->references('id')->on('transaction__main__heads')
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
        Schema::dropIfExists('transaction__withs');
    }
};
