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
        Schema::table('user_informations', function (Blueprint $table) {
            $table->boolean('dept_adab')->default(false)->after('dept_other');
            $table->string('dept_adab_year_english')->nullable()->after('dept_other_class');
            $table->string('dept_adab_year_hijri')->nullable()->after('dept_adab_year_english');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_informations', function (Blueprint $table) {
            $table->dropColumn(['dept_adab', 'dept_adab_year_english', 'dept_adab_year_hijri']);
        });
    }
};
