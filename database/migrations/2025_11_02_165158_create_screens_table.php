<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('screens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theatre_id')->constrained()->onDelete('cascade');
            $table->string('screen_name'); // Screen 1, 2, 3, etc
            $table->integer('total_seats');
            $table->decimal('base_price', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screens');
    }
};

