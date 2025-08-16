<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Single column indexes
            $table->index('fullNameBangla');
            $table->index('fatherName');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['fullNameBangla']);
            $table->dropIndex(['fatherName']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });
    }
}