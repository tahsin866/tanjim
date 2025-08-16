<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToUserInformationsTable extends Migration
{
    public function up()
    {
        Schema::table('user_informations', function (Blueprint $table) {
            // Single column indexes for filter/search
            $table->index('user_id');
            $table->index('photo');
            $table->index('dateOfBirth');
            $table->index('rollNumber');
            $table->index('workplace');
            $table->index('bloodGroup');
            $table->index('division_id');
            $table->index('district_id');
            $table->index('thana_id');

            // Department indexes
            $table->index('dept_takmil');
            $table->index('dept_ifta');
            $table->index('dept_hifz');
            $table->index('dept_qirat');

            // Year indexes (for graduation year search)
            $table->index('dept_takmil_year_english');
            $table->index('dept_ifta_year_english');
            $table->index('dept_hifz_year_english');
            $table->index('dept_qirat_year_english');
        });
    }

    public function down()
    {
        Schema::table('user_informations', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['photo']);
            $table->dropIndex(['dateOfBirth']);
            $table->dropIndex(['rollNumber']);
            $table->dropIndex(['workplace']);
            $table->dropIndex(['bloodGroup']);
            $table->dropIndex(['division_id']);
            $table->dropIndex(['district_id']);
            $table->dropIndex(['thana_id']);

            $table->dropIndex(['dept_takmil']);
            $table->dropIndex(['dept_ifta']);
            $table->dropIndex(['dept_hifz']);
            $table->dropIndex(['dept_qirat']);

            $table->dropIndex(['dept_takmil_year_english']);
            $table->dropIndex(['dept_ifta_year_english']);
            $table->dropIndex(['dept_hifz_year_english']);
            $table->dropIndex(['dept_qirat_year_english']);
        });
    }
}