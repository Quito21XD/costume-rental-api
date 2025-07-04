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
        Schema::create('costume_piece', function (Blueprint $table) {
            $table->id();
            $table->foreignId('costume_id')->constrained('costumes')->onDelete('cascade');
            $table->foreignId('piece_id')->constrained('pieces')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costume_piece');
    }
};
