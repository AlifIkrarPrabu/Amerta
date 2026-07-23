<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelatih - Raport Bulanan Atlet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Header Navigation -->
    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-file-invoice"></i> Raport Bulanan Atlet
            </h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('coach.dashboard') }}" class="bg-blue-700 hover:bg-blue-800 text-white px-3 py-1.5 rounded-lg text-sm transition flex items-center gap-1.5">
                    <i class="fas fa-arrow-left"></i> Presensi Latihan
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-lg text-sm transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container mx-auto p-4 md:p-8 space-y-8">
        
        <!-- Notifikasi -->
        @if(session('success'))
            <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter Bulan -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Evaluasi Bulanan Atlet</h2>
                <p class="text-xs text-gray-500">Pilih periode bulan untuk memasukkan atau melihat evaluasi atlet.</p>
            </div>
            <form method="GET" action="{{ route('coach.reports.index') }}" class="flex items-center gap-3">
                <input type="month" name="bulan" value="{{ $selectedMonth }}" class="border border-gray-300 rounded-lg p-2.5 text-sm font-semibold text-gray-700 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition">
                    Pilih Bulan
                </button>
            </form>
        </div>

        <!-- Daftar Atlet & Form Input Raport -->
        <div class="grid grid-cols-1 gap-6">
            @forelse($athletes as $athlete)
                @php
                    $existingReport = $reports->get($athlete->id);
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm uppercase">
                                {{ substr($athlete->name, 0, 2) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-base">{{ $athlete->name }}</h3>
                                <p class="text-xs text-gray-500">Atlet Active</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $existingReport ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $existingReport ? 'Sudah Diisi' : 'Belum Diisi Bulan Ini' }}
                        </span>
                    </div>
                    
                    <form action="{{ route('coach.reports.store') }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        <input type="hidden" name="athlete_id" value="{{ $athlete->id }}">
                        <input type="hidden" name="bulan_tahun" value="{{ $selectedMonth }}">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan / Evaluasi Bulan {{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }}
                            </label>
                            <textarea name="catatan_evaluasi" rows="3" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 border text-sm"
                                placeholder="Contoh: Gaya bebas sudah sangat baik. Fokus tingkatkan daya tahan dan perbaiki pernapasan gaya dada.">{{ $existingReport->catatan_evaluasi ?? '' }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg text-sm shadow transition">
                                <i class="fas fa-save mr-1.5"></i> Simpan Evaluasi
                            </button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="bg-white p-12 text-center text-gray-400 rounded-xl border">
                    Tidak ada data atlet.
                </div>
            @endforelse
        </div>

    </main>

</body>
</html>