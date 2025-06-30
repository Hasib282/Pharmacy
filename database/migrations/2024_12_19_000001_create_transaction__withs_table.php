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
        Schema::connection('mysql_second')->create('transaction__withs', function (Blueprint $table) {
            $table->id();
            $table->string('tran_with_name');
            $table->bigInteger('user_role')->comment('roles');
            $table->bigInteger('tran_type')->comment('transaction__main__heads');
            $table->string('tran_method');
            $table->tinyInteger('status')->default('1');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('transaction__withs');
    }
};
