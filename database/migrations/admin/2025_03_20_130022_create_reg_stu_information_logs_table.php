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
        Schema::create('reg_stu_information_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reg_student_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('status', ['বোর্ড দাখিল', 'অনুমোদন', 'বোর্ড ফেরত', 'বাতিল']);
            $table->string('actor_type')->nullable();
            $table->string('admin_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_position')->nullable();
            $table->string('admin_position')->nullable();
            $table->text('admin_message')->nullable();
            $table->string('admin_feedback_image')->nullable();
            $table->timestamps();

            // Foreign key relationship
            $table->foreign('reg_student_id')->references('id')->on('reg_stu_informations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reg_stu_information_logs');
    }
};
