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
         Schema::create('participant_meal_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // participants = users
            $table->foreignId('meal_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('food_hall_id')->constrained()->onDelete('cascade');
            $table->boolean('wants_night_stay')->default(false); // রাত্রি যাপন করতে চায় কিনা
            $table->timestamps();

            $table->unique(['event_id', 'user_id', 'meal_type_id'], 'unique_event_user_meal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('participant_meal_selections');
    }
};
