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
        Schema::create('exam_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_setup_id')->constrained('exam_setups')->onDelete('cascade');
            $table->string('exam_name');

            // Registration Fee Period
            $table->date('reg_date_from');
            $table->date('reg_date_to');
            $table->decimal('reg_regular_fee', 10, 2);
            $table->decimal('reg_irregular_jemni', 10, 2);
            $table->decimal('reg_irregular_manonnoyon', 10, 2);
            $table->decimal('reg_irregular_others', 10, 2);

            // Late Fee Period
            $table->date('late_date_from');
            $table->date('late_date_to');
            $table->decimal('late_regular_fee', 10, 2);
            $table->decimal('late_irregular_jemni', 10, 2);
            $table->decimal('late_irregular_manonnoyon', 10, 2);
            $table->decimal('late_irregular_others', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_fees');
    }
};
