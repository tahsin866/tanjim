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
        Schema::create('optional_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('marhala_id')->constrained('marhala_subjects', 'marhala_id')->onDelete('cascade');
            $table->string('subject_code');
            $table->string('name_bangla');
            $table->boolean('is_selected')->default(0); // 0 for not selected, 1 for selected
            $table->timestamps();

            // Add unique constraint to prevent duplicate selections
            $table->unique(['user_id', 'marhala_id', 'subject_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optional_subjects');
    }
};
