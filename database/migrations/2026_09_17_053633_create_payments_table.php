<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_id')->constrained('users')->onDelete('cascade');
            $table->string('bulan_tahun'); // Format: YYYY-MM
            $table->date('tanggal_bayar');
            $table->bigInteger('jumlah')->default(0); // Menggunakan bigInteger agar tepat akurat
            $table->enum('metode_pembayaran', ['Cash', 'Transfer'])->default('Cash');
            $table->enum('status', ['Lunas', 'Pending'])->default('Lunas');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};