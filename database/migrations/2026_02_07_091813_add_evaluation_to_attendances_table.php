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
        // Pastikan nama tabel sesuai dengan nama tabel presensi Anda (biasanya 'attendances')
        Schema::table('attendances', function (Blueprint $table) {
            /**
             * Menambahkan kolom 'evaluation' dengan tipe TEXT.
             * nullable() : Memberikan izin kolom ini kosong di database.
             * after('materi') : Meletakkan posisi kolom setelah kolom materi (opsional/estetik database).
             */
            $table->text('evaluation')->nullable()->after('materi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('evaluation');
        });
    }
};