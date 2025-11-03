<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screen_id')->constrained()->onDelete('cascade');
            $table->string('seat_number'); // A1, A2, B1, etc
            $table->integer('row_number');
            $table->integer('column_number');
            $table->enum('seat_type', ['standard', 'premium', 'recliner']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
