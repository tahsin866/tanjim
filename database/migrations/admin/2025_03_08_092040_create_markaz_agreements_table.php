<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ public function up()
    {
        Schema::create('markaz_agreements', function (Blueprint $table) {
            $table->id();

            // Main Madrasa Information
            $table->string('markaz_type')->nullable();
            $table->integer('fazilat')->nullable();
            $table->integer('sanabiya_ulya')->nullable();
            $table->integer('sanabiya')->nullable();
            $table->integer('mutawassita')->nullable();
            $table->integer('ibtedaiyyah')->nullable();
            $table->integer('hifzul_quran')->nullable();

            // Main Madrasa Documents
            $table->string('noc_file')->nullable();
            $table->string('resolution_file')->nullable();

            // Requirements
            $table->text('requirements')->nullable();

            // Attachments
            $table->string('muhtamim_consent')->nullable();
            $table->string('president_consent')->nullable();
            $table->string('committee_resolution')->nullable();

            $table->timestamps();
        });

        // Associated Madrasa Information
        Schema::create('markaz_agreement_madrasas', function (Blueprint $table) {
            $table->id();
            $table->string('markaz_type')->nullable();
            $table->foreignId('markaz_agreement_id')->constrained()->onDelete('cascade');
            $table->foreignId('madrasa_id')->nullable();

            // Student Counts
            $table->integer('fazilat')->nullable();
            $table->integer('sanabiya_ulya')->nullable();
            $table->integer('sanabiya')->nullable();
            $table->integer('mutawassita')->nullable();
            $table->integer('ibtedaiyyah')->nullable();
            $table->integer('hifzul_quran')->nullable();

            // Documents
            $table->string('noc_file')->nullable();
            $table->string('resolution_file')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('markaz_agreement_madrasas');
        Schema::dropIfExists('markaz_agreements');
    }
};
