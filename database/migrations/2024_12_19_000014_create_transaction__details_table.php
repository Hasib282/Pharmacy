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
        Schema::connection('mysql_second')->create('transaction__details', function (Blueprint $table) {
            $table->id();
            $table->string('tran_id');
            $table->bigInteger('tran_type')->comment('transaction__main__heads');
            $table->string('tran_method');
            $table->string('invoice')->nullable();
            $table->bigInteger('loc_id')->nullable()->comment('location_infos');
            $table->unsignedBigInteger('tran_type_with')->nullable();
            $table->string('tran_bank')->nullable();
            $table->string('tran_user')->nullable();
            $table->string('ptn_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('user_address')->nullable();
            $table->unsignedBigInteger('tran_groupe_id')->nullable();
            $table->unsignedBigInteger('tran_head_id')->nullable();
            $table->double('quantity_actual')->default(1);
            $table->double('quantity')->default(1);
            $table->double('quantity_issue')->default(0);
            $table->double('quantity_return')->default(0);
            $table->unsignedBigInteger('unit_id')->nullable()->comment('item__units');
            $table->double('amount')->nullable();
            $table->double('tot_amount')->nullable();
            $table->double('discount')->nullable();
            $table->double('cp')->nullable();
            $table->double('mrp')->nullable();
            $table->double('receive')->nullable();
            $table->double('payment')->nullable();
            $table->double('due')->nullable();
            $table->double('due_col')->default(0)->nullable();
            $table->double('due_disc')->default(0)->nullable();
            $table->date('expiry_date')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('payment_mode')->nullable();
            $table->string('batch_id')->nullable();
            $table->string('booking_id')->nullable();
            $table->timestamp('tran_date')->useCurrent();
            $table->tinyInteger('status')->default('1')->comment('1 for Active 0 for Inactive');
            $table->timestamp('updated_at')->nullable();
            
            // Foreignkey Decleration
            $table->foreign('tran_type_with')->references('id')->on('transaction__withs')
                    ->onUpdate('cascade');
        //     $table->foreign('tran_groupe_id')->references('id')->on('transaction__groupes')
        //             ->onUpdate('cascade');
        //     $table->foreign('tran_head_id')->references('id')->on('transaction__heads')
        //             ->onUpdate('cascade');
            // $table->foreign('tran_user')->references('user_id')->on('user__infos')
            //         ->onUpdate('cascade');
            $table->foreign('store_id')->references('id')->on('stores')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('transaction__details');
    }
};
