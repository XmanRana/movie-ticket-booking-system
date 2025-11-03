<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->foreignId('screen_id')->constrained()->onDelete('cascade');
            $table->dateTime('show_time');
            $table->decimal('ticket_price', 8, 2);
            $table->enum('show_type', ['morning', 'afternoon', 'evening', 'night']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shows');
    }
};
