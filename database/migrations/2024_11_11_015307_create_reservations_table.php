<?php

use App\DataValues\ReservationStatus;
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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('reservation_status')
                ->default(ReservationStatus::PENDING);
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->timestamps();

            $table->foreignId('user_id')
                ->constrained('users')
                ->noActionOnDelete()
                ->noActionOnUpdate();

            $table->foreignId('office_id')
                ->constrained('offices')
                ->noActionOnDelete()
                ->noActionOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
