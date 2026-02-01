<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Atlet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex">
        

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Nav -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Dashboard Atlet</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Halo, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Keluar</button>
                    </form>
                </div>
            </header>

            <main class="p-6">
                <!-- Status Paket & Peringatan -->
                <div class="mb-8">
                    @php
                        // Menghitung total kehadiran dari koleksi attendances
                        $totalKehadiran = $attendances->count();
                        $kuotaMaksimal = 4;
                    @endphp

                    @if($totalKehadiran >= $kuotaMaksimal)
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                                <div>
                                    <p class="font-bold">Paket latihan Anda sudah habis!</p>
                                    <p>Silahkan untuk melakukan pembayaran agar dapat melanjutkan sesi latihan berikutnya.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle mr-3 text-xl"></i>
                                <div>
                                    <p class="font-bold">Informasi Paket</p>
                                    <p>Sisa kuota latihan Anda: {{ $kuotaMaksimal - $totalKehadiran }} sesi lagi.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Grid Statistik Utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Kehadiran Card -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Total Kehadiran</p>
                                <h3 class="text-3xl font-bold text-indigo-600">{{ $totalKehadiran }}</h3>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-lg text-indigo-600">
                                <i class="fas fa-calendar-check fa-2x"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm">
                            <span class="text-gray-400">Dari batas {{ $kuotaMaksimal }} pertemuan</span>
                        </div>
                    </div>

                    <!-- Progress Latihan (Contoh) -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Status Paket</p>
                                <h3 class="text-xl font-bold {{ $totalKehadiran >= 4 ? 'text-red-500' : 'text-green-500' }}">
                                    {{ $totalKehadiran >= 4 ? 'Non-Aktif' : 'Aktif' }}
                                </h3>
                            </div>
                            <div class="{{ $totalKehadiran >= 4 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} p-3 rounded-lg">
                                <i class="fas fa-user-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Kehadiran -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Riwayat Kehadiran Terakhir</h3>
                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-indigo-600 bg-indigo-200 uppercase last:mr-0 mr-1">
                            Bulan Ini
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-600 text-sm">
                                <tr>
                                    <th class="py-4 px-6 font-semibold">Tanggal</th>
                                    <th class="py-4 px-6 font-semibold">Waktu</th>
                                    <th class="py-4 px-6 font-semibold">Kegiatan</th>
                                    <th class="py-4 px-6 font-semibold text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($attendances as $attendance)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-6">{{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}</td>
                                    <td class="py-4 px-6">{{ $attendance->time ?? '--:--' }}</td>
                                    <td class="py-4 px-6">{{ $attendance->activity ?? 'Latihan Reguler' }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Hadir</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-10 px-6 text-center text-gray-400 italic">
                                        Belum ada data kehadiran.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>