<?php

use App\Models\Room_Catagory;
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
        Schema::connection('mysql_second')->create('room__lists', function (Blueprint $table) {
            $table->id();
            $table->string("room_number");
            $table->string("room_catagory");
            $table->string("floor");
            $table->string("price");
            $table->integer("capacity");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('room__lists');
    }
};
