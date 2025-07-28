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
        Schema::create('user_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('alternatePhoneNumber')->nullable();
            $table->date('dateOfBirth');
            $table->string('bloodGroup')->nullable();
            $table->text('address');
            $table->integer('division_id');
            $table->integer('district_id');
            $table->integer('thana_id');
            $table->string('classmate1')->nullable();
            $table->string('classmate2')->nullable();
            $table->string('classmate3')->nullable();
            $table->boolean('dept_takmil')->default(false);
            $table->boolean('dept_ifta')->default(false);
            $table->boolean('dept_hifz')->default(false);
            $table->boolean('dept_qirat')->default(false);
            $table->boolean('dept_other')->default(false);
            $table->string('dept_takmil_year_english')->nullable();
            $table->string('dept_takmil_year_hijri')->nullable();
            $table->string('dept_ifta_year_english')->nullable();
            $table->string('dept_ifta_year_hijri')->nullable();
            $table->string('dept_hifz_year_english')->nullable();
            $table->string('dept_hifz_year_hijri')->nullable();
            $table->string('dept_qirat_year_english')->nullable();
            $table->string('dept_qirat_year_hijri')->nullable();
            $table->string('dept_other_name')->nullable();
            $table->string('dept_other_class')->nullable();
            $table->string('examType');
            $table->string('rollNumber');
            $table->string('workplace')->nullable();
            $table->string('idType');
            $table->string('birthCertificate')->nullable();
            $table->string('voterId')->nullable();
            $table->string('birthCertificatePhoto')->nullable();
            $table->string('voterIdPhoto')->nullable();
            $table->string('photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_informations');
    }
};