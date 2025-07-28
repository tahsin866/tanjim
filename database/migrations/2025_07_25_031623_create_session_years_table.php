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
        Schema::create('session_years', function (Blueprint $table) {
            $table->id();
            $table->integer('english_year')->unique()->comment('ইংরেজি বর্ষ');
            $table->string('hijri_year', 20)->comment('হিজরি বর্ষ (যেমন: 1369 - 1370)');
            $table->integer('hijri_start')->comment('হিজরি শুরুর বছর');
            $table->integer('hijri_end')->comment('হিজরি শেষের বছর');
            $table->timestamps();

            // Index for better performance
            $table->index('english_year');
            $table->index('hijri_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_years');
    }
};
