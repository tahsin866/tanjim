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
        Schema::create('student_reg_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('students_id');
            $table->unsignedBigInteger('exam_id');
            $table->string('exam_name_Bn');
            $table->unsignedBigInteger('madrasha_id');
            $table->unsignedBigInteger('user_id');
            $table->string('class');
            $table->string('student_type');
            $table->tinyInteger('payment_status')->default(0)->comment('1=paid, 0=unpaid');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('students_id')->references('id')->on('reg_stu_informations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_reg_payments');
    }
};
