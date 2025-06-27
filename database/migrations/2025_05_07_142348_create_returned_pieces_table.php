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
        Schema::create('returned_pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_record_id')->constrained('return_records')->onDelete('cascade');
            $table->foreignId('piece_id')->constrained('pieces')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('damage_fee')->default(0); // penalizacion por estado
            $table->string('piece_status')->default('good');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returned_pieces');
    }
};
