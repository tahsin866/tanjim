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
        Schema::create('marhala_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marhala_id')->constrained()->onDelete('cascade');
            $table->string('subject_code');
            $table->string('name_bangla');
            $table->string('name_english');
            $table->string('name_arabic');
            $table->enum('status', ['SRtype_1', 'SRtype_0', 'both'])->comment('SRtype_1=Male, SRtype_0=Female, both=Both');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marhala_subjects');
    }
};
