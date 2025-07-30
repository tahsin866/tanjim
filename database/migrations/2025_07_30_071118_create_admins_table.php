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
        if (!Schema::hasTable('admins')) {
            Schema::create('admins', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->enum('role', ['super_admin', 'admin', 'moderator'])->default('moderator');
                $table->boolean('is_active')->default(true);
                $table->string('department')->nullable();
                $table->string('designation')->nullable();
                $table->string('phone')->nullable();
                $table->string('profile_image')->nullable();
                $table->year('graduation_year')->nullable();
                $table->json('permissions')->nullable();
                $table->timestamp('last_login_at')->nullable();
                $table->string('last_login_ip')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');
                $table->foreignId('updated_by')->nullable()->constrained('admins')->onDelete('set null');
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
