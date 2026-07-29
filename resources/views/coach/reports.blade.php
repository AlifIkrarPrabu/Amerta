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

        <!-- Filter Bulan & Input Pencarian -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Evaluasi Bulanan Atlet</h2>
                <p class="text-xs text-gray-500">Pilih periode bulan dan cari atlet untuk memasukkan atau melihat evaluasi.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <!-- Input Fitur Pencarian Nama Atlet -->
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" id="searchAthleteReport" placeholder="Cari nama atlet..." 
                        class="pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm">
                </div>

                <!-- Form Filter Bulan -->
                <form method="GET" action="{{ route('coach.reports.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
                    <input type="month" name="bulan" value="{{ $selectedMonth }}" class="border border-gray-300 rounded-lg p-2 text-sm font-semibold text-gray-700 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shrink-0">
                        Pilih Bulan
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Atlet & Form Input Raport -->
        <div class="grid grid-cols-1 gap-6" id="athleteListContainer">
            @forelse($athletes as $athlete)
                @php
                    $existingReport = $reports->get($athlete->id);
                @endphp
                <div class="athlete-card bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" 
                     data-athlete-name="{{ strtolower($athlete->name) }}">
                    <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm uppercase">
                                {{ substr($athlete->name, 0, 2) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-base athlete-name-display">{{ $athlete->name }}</h3>
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

            <!-- Pesan jika hasil pencarian nama atlet tidak ditemukan -->
            <div id="noSearchMatch" class="hidden bg-white p-12 text-center text-gray-400 rounded-xl border">
                <i class="fas fa-search text-3xl mb-3 text-gray-300 block"></i>
                Tidak ditemukan atlet dengan nama tersebut.
            </div>
        </div>

    </main>

    <!-- Script Live Search -->
    <script>
        document.getElementById('searchAthleteReport').addEventListener('keyup', function () {
            let filterValue = this.value.toLowerCase().trim();
            let athleteCards = document.querySelectorAll('.athlete-card');
            let visibleCount = 0;

            athleteCards.forEach(function (card) {
                let athleteName = card.getAttribute('data-athlete-name');
                if (athleteName.includes(filterValue)) {
                    card.style.display = "";
                    visibleCount++;
                } else {
                    card.style.display = "none";
                }
            });

            // Tampilkan pesan "tidak ditemukan" jika tidak ada nama yang cocok
            let noMatchDiv = document.getElementById('noSearchMatch');
            if (visibleCount === 0 && athleteCards.length > 0) {
                noMatchDiv.classList.remove('hidden');
            } else {
                noMatchDiv.classList.add('hidden');
            }
        });
    </script>

</body>
</html>