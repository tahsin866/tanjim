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
        Schema::create('reg_stu_informations', function (Blueprint $table) {
            $table->id();

            // Foreign key relationships
            $table->unsignedBigInteger('exam_id');
            $table->foreign('exam_id')->references('id')->on('exam_setups')->onDelete('cascade');
            $table->string('exam_name_Bn')->nullable();

            // $table->unsignedBigInteger('madrasha_id');
            $table->string('madrasha_id');
            $table->string('madrasha_name')->nullable();

            // Markaz information
            $table->string('markaz_serial')->nullable();
            $table->string('markaz_name')->nullable();

            // Student personal information
            $table->string('name_bn');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();

            // Parent information
            $table->string('father_name_bn');
            $table->string('father_name_en')->nullable();
            $table->string('father_name_ar')->nullable();
            $table->string('mother_name_bn');
            $table->string('mother_name_en')->nullable();
            $table->string('mother_name_ar')->nullable();

            $table->string('Roll')->nullable();
            $table->string('reg_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('user_name')->nullable();
            $table->string('madrasha_code')->nullable();
            // Identification information
            $table->string('BRN_no')->nullable();
            $table->string('NID_no')->nullable();

            // Academic information
            $table->string('class');
            $table->string('student_type')->nullable();
            $table->text('exam_books')->nullable();

            // Address information
            $table->string('division_name')->nullable();
            $table->unsignedBigInteger('DID')->nullable(); // Division ID
            $table->string('district_name')->nullable();
            $table->unsignedBigInteger('des_id')->nullable(); // District ID
            $table->string('thana_name')->nullable();
            $table->unsignedBigInteger('TID')->nullable(); // Thana ID

            // Attachments
            $table->string('student_image')->nullable();
            $table->string('NID_attach')->nullable();
            $table->string('BRN_attach')->nullable();

            // Timestamps
            $table->timestamps();

            // Indexes for better query performance
            $table->index('exam_id');
            $table->index('madrasha_id');
            $table->index(['DID', 'des_id', 'TID']);
            $table->index(['Roll', 'reg_id']);
            $table->index('madrasha_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reg_stu_informations');
    }
};
