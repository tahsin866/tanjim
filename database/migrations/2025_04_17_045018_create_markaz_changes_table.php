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
        Schema::create('markaz_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('central_exam_id')->constrained('exam_setups');
            $table->unsignedBigInteger('madrasha_id');
            $table->unsignedBigInteger('markaz_id');
            $table->string('madrasha_name');
            $table->string('asking_madrasha');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markaz_changes');
    }
};
