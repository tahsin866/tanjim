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
        Schema::create('schedule_setups', function (Blueprint $table) {
             $table->id();
            $table->foreignId('exam_setup_id')->constrained('exam_setups')->onDelete('cascade');
            $table->string('schedule_type'); // For 'নেগরান/মুমতাহিন' or 'মারকায আবেদন'
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_setups');
    }
};
