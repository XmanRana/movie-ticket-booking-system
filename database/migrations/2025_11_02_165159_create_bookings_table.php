<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('show_id')->constrained()->onDelete('cascade');
            $table->integer('number_of_seats');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['pending', 'completed', 'cancelled']);
            $table->string('booking_reference')->unique();
            $table->timestamp('booking_date');
            $table->timestamp('show_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
