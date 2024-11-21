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
        Schema::create('transaction__mains', function (Blueprint $table) {
            $table->id();
            $table->string('tran_id')->unique();
            $table->unsignedBigInteger('tran_type');
            $table->string('tran_method');
            $table->string('invoice')->nullable();
            $table->unsignedBigInteger('loc_id')->nullable();
            $table->unsignedBigInteger('tran_type_with')->nullable();
            $table->string('tran_user')->nullable();
            $table->string('tran_bank')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('user_address')->nullable();
            $table->float('bill_amount')->nullable();
            $table->float('discount')->default('0');
            $table->float('net_amount')->nullable();
            $table->float('receive')->nullable();
            $table->float('payment')->nullable();
            $table->float('due')->nullable();
            $table->float('due_col')->default(0)->nullable();
            $table->float('due_disc')->default(0)->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->timestamp('tran_date')->useCurrent();
            $table->tinyInteger('status')->default('1')->comment('1 for Active 0 for Inactive');
            $table->string('company_id')->nullable();
            $table->timestamp('updated_at')->nullable();
            
            // Foreignkey Decleration
            $table->foreign('tran_type')->references('id')->on('transaction__main__heads')
                    ->onUpdate('cascade');
            $table->foreign('loc_id')->references('id')->on('location__infos')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('tran_type_with')->references('id')->on('transaction__withs')
                    ->onUpdate('cascade');
            $table->foreign('tran_user')->references('user_id')->on('user__infos')
                    ->onUpdate('cascade');
            $table->foreign('tran_bank')->references('user_id')->on('banks')
                    ->onUpdate('cascade');
            $table->foreign('store_id')->references('id')->on('stores')
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
        Schema::dropIfExists('transaction__mains');
    }
};
