<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $blueprint) {
            $blueprint->id();
            // ID Pelatih yang menginput
            $blueprint->foreignId('coach_id')->constrained('users')->onDelete('cascade');
            // ID Atlet yang hadir
            $blueprint->foreignId('athlete_id')->constrained('users')->onDelete('cascade');
            $blueprint->date('tanggal');
            $blueprint->string('tempat');
            $blueprint->text('materi')->nullable();
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};