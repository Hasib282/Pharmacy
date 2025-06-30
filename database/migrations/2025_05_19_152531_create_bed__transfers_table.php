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
        Schema::connection('mysql_second')->create('bed__transfers', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id');
            $table->string('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('from_bed');
            $table->unsignedBigInteger('to_bed');
            $table->timestamp('transfer_date')->nullable();
            $table->timestamp('transfer_by')->nullable();
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
        Schema::connection('mysql_second')->dropIfExists('bed__transfers');
    }
};
