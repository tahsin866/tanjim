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
            $table->integer('division_id');
            $table->integer('district_id');
            $table->integer('thana_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_informations', function (Blueprint $table) {
            $table->dropColumn(['division_id', 'district_id', 'thana_id']);
        });
    }
};