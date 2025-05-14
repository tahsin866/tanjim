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
        Schema::create('neg_mumtahin_aplications', function (Blueprint $table) {
            $table->id(); // প্রাইমারি কি যোগ করা হয়েছে
            $table->string('name');
            $table->string('mobile');
            $table->date('birth_date');
            $table->string('whatsapp')->nullable();
            $table->string('birth_reg_no')->nullable();
            $table->string('nid')->nullable();
            $table->enum('gender', ['পুরুষ', 'মহিলা', 'অন্যান্য'])->default('পুরুষ');
            $table->string('profile_image')->nullable();
            // Address
            $table->string('division');
            $table->string('district');
            $table->string('thana');
            $table->string('post');
            $table->string('village');
            // Application Type
            $table->enum('application_type', ['নেগরান', 'মুমতাহিন', 'নেগরান মুমতাহিন উভয়', 'হিফজ মুমতাহিন', 'কেরাত মুমতাহিন'])->default('নেগরান');
            // Teaching Experience
            $table->text('teaching_experience')->nullable();
            // Desired Book
            $table->string('selected_book')->nullable();
            // Payment Information
            $table->string('nagad_number')->nullable();
            $table->string('rocket_number')->nullable();
            $table->string('bkash_number')->nullable();
            // File Attachments
            $table->string('muhtamim_file')->nullable();
            $table->string('nid_file')->nullable();
            $table->string('birth_cert_file')->nullable();
            // Comments
            $table->text('comments')->nullable();
            // Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });

        // Educational Qualifications (separate table with foreign key)
        Schema::create('educational_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('neg_mumtahin_aplications')->onDelete('cascade');
            $table->string('class_name');
            $table->string('pass_year')->nullable();
            $table->string('result')->nullable();
            $table->string('institution')->nullable();
            $table->timestamps();
        });

        Schema::create('book_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('book_categories')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neg_mumtahin_aplications');
        Schema::dropIfExists('educational_qualifications');
        Schema::dropIfExists('books');
        Schema::dropIfExists('book_categories');

    }
};
