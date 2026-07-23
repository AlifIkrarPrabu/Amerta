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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('coach_id')->constrained('users')->onDelete('cascade');
            $table->string('bulan_tahun'); // Contoh isi: "2026-07" atau "2026-08"
            $table->text('catatan_evaluasi'); // Teks evaluasi bulanan
            $table->timestamps();

            // Memastikan 1 atlet hanya punya 1 raport dalam 1 bulan yang sama dari pelatih yang sama
            $table->unique(['athlete_id', 'bulan_tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};