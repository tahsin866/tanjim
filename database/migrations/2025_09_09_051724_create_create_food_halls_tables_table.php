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
        Schema::create('create_food_halls_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ভবনের নাম
            $table->unsignedInteger('capacity'); // সর্বোচ্চ ধারণক্ষমতা
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_food_halls_tables');
    }
};
