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
        Schema::create('questions', function (Blueprint $table) {
            $table->id('soal_id');
            $table->integer('soal_persidangan'); // lookup to `conferences` table `conf_id`
            $table->integer('soal_kategori'); // category
            $table->integer('soal_soalan_no'); // Question number
            $table->text('soal_soalan'); // question
            $table->text('soal_jawapan'); // answer
            $table->integer('soal_adun'); // lookup to `user` table `id`
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
