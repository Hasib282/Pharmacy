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
        Schema::connection('mysql_second')->create('transaction__heads', function (Blueprint $table) {
            $table->id();
            $table->string('tran_head_name');
            $table->unsignedBigInteger('groupe_id')->nullabe();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('manufacturer_id')->nullable();
            $table->unsignedBigInteger('form_id')->nullable();
            $table->unsignedBigInteger('unit_id')->default(1);
            $table->double('quantity')->default(0);
            $table->double('cp')->default(0);
            $table->double('mrp')->default(0);
            $table->date('expiry_date')->nullable();
            $table->boolean('editable')->default(0);
            $table->string('company_id')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            // Foreignkey Decleration
        //     $table->foreign('groupe_id')->references('id')->on('transaction__groupes')
        //             ->onUpdate('cascade')
        //             ->onDelete('cascade');
        //     $table->foreign('category_id')->references('id')->on('item__categories')
        //             ->onUpdate('cascade')
        //             ->onDelete('cascade');
        //     $table->foreign('manufacturer_id')->references('id')->on('item__manufacturers')
        //             ->onUpdate('cascade')
        //             ->onDelete('cascade');
        //     $table->foreign('form_id')->references('id')->on('item__forms')
        //             ->onUpdate('cascade')
        //             ->onDelete('cascade');
        //     $table->foreign('unit_id')->references('id')->on('item__units')
        //             ->onUpdate('cascade')
        //             ->onDelete('cascade');
        //     $table->foreign('company_id')->references('company_id')->on('company__details')
        //             ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('transaction__heads');
    }
};
