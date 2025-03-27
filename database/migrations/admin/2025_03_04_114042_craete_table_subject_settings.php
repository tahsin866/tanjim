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
        //
        Schema::create('subject_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marhala_id')->constrained('marhalas')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('marhala_subjects')->onDelete('cascade');
            $table->string('Marhala_type');
            $table->string('Subject_Names');
            $table->string('student_type');
            $table->string('syllabus_type');
            $table->string('markaz_type');
            $table->string('subject_type');
            $table->integer('total_marks');
            $table->integer('pass_marks');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
