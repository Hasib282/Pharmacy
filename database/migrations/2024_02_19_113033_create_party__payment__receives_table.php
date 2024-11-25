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
        Schema::create('party__payment__receives', function (Blueprint $table) {
            $table->id();
            $table->string('tran_id');
            $table->unsignedBigInteger('tran_type');
            $table->string('tran_method');
            $table->string('invoice')->nullable();
            $table->unsignedBigInteger('loc_id')->nullable();
            $table->unsignedBigInteger('tran_type_with')->nullable();
            $table->string('tran_user')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('user_address')->nullable();
            $table->unsignedBigInteger('tran_groupe_id')->nullable();
            $table->unsignedBigInteger('tran_head_id')->nullable();
            $table->float('quantity')->default(1);
            $table->float('bill_amount');
            $table->float('discount')->default(0);
            $table->float('net_amount');
            $table->float('receive')->nullable();
            $table->float('payment')->nullable();
            $table->float('due')->default(0);
            $table->float('party_amount')->nullable();
            $table->string('batch_id')->nullable();
            $table->timestamp('tran_date')->useCurrent();
            $table->tinyInteger('status')->default('1')->comment('1 for Active 0 for Inactive');
            $table->string('company_id')->nullable();
            $table->timestamp('updated_at')->nullable();
            
            // Foreignkey Decleration
            $table->foreign('tran_type')->references('id')->on('transaction__main__heads')
                    ->onUpdate('cascade');
            $table->foreign('loc_id')->references('id')->on('location__infos')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
            $table->foreign('tran_type_with')->references('id')->on('transaction__withs')
                    ->onUpdate('cascade');
            $table->foreign('tran_groupe_id')->references('id')->on('transaction__groupes')
                    ->onUpdate('cascade');
            $table->foreign('tran_head_id')->references('id')->on('transaction__heads')
                    ->onUpdate('cascade');
            $table->foreign('tran_user')->references('user_id')->on('user__infos')
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
        Schema::dropIfExists('party__payment__receives');
    }
};
