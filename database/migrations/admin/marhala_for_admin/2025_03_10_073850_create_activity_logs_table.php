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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('markaz_agreement_id')->constrained()->onDelete('cascade');

            // Ensure admin_id and user_id are unsignedBigInteger
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->enum('status', ['সাবমিটেড', 'অনুমোদন', 'ফেরত পাঠানো', 'বাতিল']);
            $table->string('actor_type');
            $table->string('admin_name');
            $table->string('user_name');
            $table->string('user_position');
            $table->string('admin_position');
            $table->text('admin_message')->nullable();
            $table->string('admin_feedback_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
