<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Atlet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="min-h-screen flex flex-col lg:flex-row bg-gray-100">
    
    @include('partials.sidebar-athlete')

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <header class="bg-white shadow-sm p-4 flex justify-between items-center border-b border-gray-100 relative w-full z-20">
            <div class="flex items-center space-x-3 min-w-0">
                
                <button id="hamburgerBtn" type="button" class="lg:hidden bg-slate-900 hover:bg-slate-800 text-white p-2.5 rounded-xl shadow-md focus:outline-none transition flex items-center justify-center flex-shrink-0 w-10 h-10" aria-label="Open Sidebar">
                    <i class="fas fa-bars text-base"></i>
                </button>
                
                <h2 class="text-base lg:text-xl font-bold text-gray-800 truncate select-none">
                    Dashboard Atlet
                </h2>
            </div>
            
            <div class="flex items-center space-x-2 flex-shrink-0">
                <span class="text-xs lg:text-sm text-gray-600 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100 font-medium max-w-[150px] lg:max-w-none truncate">
                    <i class="far fa-user text-indigo-500 mr-1.5"></i>Halo, {{ Auth::user()->name }}
                </span>
            </div>
        </header>

            <main class="flex-1 overflow-y-auto p-6 max-w-[1600px] w-full mx-auto">
                
                <div class="mb-8">
                    @php
                        $totalKehadiran = $attendances->count();
                        $kuotaMaksimal = 4;
                    @endphp

                    @if($totalKehadiran >= $kuotaMaksimal)
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-xl shadow-sm border border-red-100" role="alert">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle mr-3 text-red-500 text-xl mt-0.5"></i>
                                <div>
                                    <p class="font-bold text-red-900">Paket latihan Anda sudah habis!</p>
                                    <p class="text-sm text-red-700 mt-0.5">Silahkan untuk melakukan pembayaran agar dapat melanjutkan sesi latihan berikutnya.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-indigo-50 border-l-4 border-indigo-500 text-indigo-900 p-4 rounded-xl shadow-sm border border-indigo-100">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle mr-3 text-indigo-500 text-xl mt-0.5"></i>
                                <div>
                                    <p class="font-bold text-indigo-950">Informasi Paket</p>
                                    <p class="text-sm text-indigo-700 mt-0.5">Sisa kuota latihan Anda: <strong class="text-indigo-900 font-bold">{{ $kuotaMaksimal - $totalKehadiran }}</strong> sesi lagi.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 font-medium uppercase tracking-wider text-xs">Total Kehadiran</p>
                            <h3 class="text-3xl font-bold text-indigo-600 mt-1">{{ $totalKehadiran }}</h3>
                            <p class="text-xs text-gray-400 mt-2">Dari batas {{ $kuotaMaksimal }} pertemuan</p>
                        </div>
                        <div class="bg-indigo-50 p-4 rounded-xl text-indigo-600">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 font-medium uppercase tracking-wider text-xs">Status Paket</p>
                            <h3 class="text-2xl font-bold mt-1 {{ $totalKehadiran >= 4 ? 'text-red-500' : 'text-emerald-500' }}">
                                {{ $totalKehadiran >= 4 ? 'Non-Aktif' : 'Aktif' }}
                            </h3>
                            <p class="text-xs text-gray-400 mt-2">Berdasarkan pemakaian kuota</p>
                        </div>
                        <div class="p-4 rounded-xl {{ $totalKehadiran >= 4 ? 'bg-red-50 text-red-500' : 'bg-emerald-50 text-emerald-500' }}">
                            <i class="fas fa-user-clock fa-2x"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-base font-bold text-gray-800 flex items-center">
                            <i class="fas fa-history text-indigo-500 mr-2"></i>Riwayat Kehadiran Terakhir
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50/70 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                                <tr>
                                    <th class="py-3.5 px-6 font-semibold">Tanggal</th>
                                    <th class="py-3.5 px-6 font-semibold">Evaluasi</th>
                                    <th class="py-3.5 px-6 font-semibold">Kegiatan</th>
                                    <th class="py-3.5 px-6 font-semibold text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($attendances as $attendance)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-medium text-gray-700">
                                        {{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($attendance->evaluation)
                                            <div class="text-xs text-gray-700 bg-amber-50 p-2.5 rounded-lg border border-amber-200/60 max-w-md">
                                                <i class="fas fa-comment-dots text-amber-500 mr-1"></i>
                                                {{ $attendance->evaluation }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic text-xs">Tidak ada evaluasi</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-gray-600">{{ $attendance->activity ?? 'Latihan Reguler' }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            Hadir
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-10 px-6 text-center text-gray-400 italic">
                                        <i class="fas fa-folder-open mb-2 text-xl block text-gray-300"></i>Belum ada data kehadiran.
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