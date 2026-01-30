<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelatih - Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-user-clock"></i> Presensi Latihan
            </h1>
            <div class="flex items-center gap-4">
                <span class="text-sm hidden md:inline">Halo, Coach {{ Auth::user()->name ?? 'Pelatih' }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container mx-auto p-4 md:p-8 space-y-12">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <!-- FORM INPUT PRESENSI -->
        <section>
            <form action="{{ route('presensi.store') }}" method="POST" id="presensiForm">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Kolom Kiri: Detail Sesi -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                            <h2 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Detail Sesi Latihan</h2>
                            
                            <div class="space-y-4">
                                <!-- Tanggal -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Latihan</label>
                                    <input type="date" name="tanggal" required 
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border"
                                        value="{{ date('Y-m-d') }}">
                                </div>

                                <!-- Tempat -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Tempat Latihan</label>
                                    <select name="tempat" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border">
                                        <option value="">Pilih Lokasi</option>
                                        <option value="Pucung">Pucung</option>
                                        <option value="Tirta Santika">Tirta Santika</option>
                                    </select>
                                </div>

                                <!-- Materi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Materi Latihan (Opsional)</label>
                                    <textarea name="materi" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border" placeholder="Contoh: Gaya Bebas"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Daftar Atlet -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <h2 class="text-lg font-semibold text-gray-700">Pilih Atlet Hadir</h2>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" id="searchAthlete" placeholder="Cari nama atlet..." 
                                        class="pl-10 pr-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold">
                                        <tr>
                                            <th class="px-6 py-3 w-16 text-center">Pilih</th>
                                            <th class="px-6 py-3">Nama Lengkap</th>
                                            <th class="px-6 py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="athleteTable" class="divide-y divide-gray-200">
                                        @forelse($athletes as $athlete)
                                        <tr class="hover:bg-blue-50 transition">
                                            <td class="px-6 py-4 text-center">
                                                <input type="checkbox" name="athletes[]" value="{{ $athlete->id }}" class="athlete-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs uppercase">
                                                        {{ substr($athlete->name, 0, 2) }}
                                                    </div>
                                                    <span class="font-medium text-gray-800">{{ $athlete->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-semibold">Aktif</span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                                                Tidak ada data atlet tersedia.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Cepat -->
                        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                            <h3 class="text-blue-800 font-semibold mb-2">Ringkasan Presensi</h3>
                            <p class="text-sm text-blue-600 mb-4">Pastikan data atlet yang dipilih sudah sesuai.</p>
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Total Terpilih:</span>
                                <span id="selectedCount" class="font-bold text-xl text-blue-700">0</span>
                            </div>
                            <button type="submit" class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-lg transition-all transform hover:scale-[1.02]">
                                Simpan Presensi
                            </button>
                        </div>
                </div>
            </form>
        </section>

        <!-- SEKSI RIWAYAT PRESENSI -->
        <section class="mt-12">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-white">
                    <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-history text-blue-500"></i> Riwayat Presensi Terbaru
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Lokasi</th>
                                <th class="px-6 py-3">Materi</th>
                                <th class="px-6 py-3">Atlet Hadir</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
        @forelse($attendanceHistory ?? [] as $history)
        <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">
                {{ \Carbon\Carbon::parse($history->tanggal)->format('d M Y') }}
            </td>
            <td class="px-6 py-4 text-gray-600 italic">
                {{ $history->tempat }}
            </td>
            <td class="px-6 py-4 text-gray-600">
                <span class="truncate block max-w-xs">{{ $history->materi ?? '-' }}</span>
            </td>
            <td class="px-6 py-4">
                <div class="flex items-center gap-1">
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-0.5 rounded-full">
                        {{ $history->athletes_count ?? 0 }} Atlet
                    </span>
                </div>
            </td>
                <td class="px-6 py-4">
                    {{-- Form Hapus --}}
                    <form action="{{ route('coach.attendance.destroy') }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data presensi sesi ini?')">
                    @csrf
                    @method('DELETE')

                                {{-- Data Identitas Sesi untuk dicocokkan di Controller --}}
                                <input type="hidden" name="tanggal" value="{{ $history->tanggal }}">
                                <input type="hidden" name="tempat" value="{{ $history->tempat }}">
                                <input type="hidden" name="materi" value="{{ $history->materi }}">
                                
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm transition-colors">
                                    Hapus
                                </button>
                            </form>
                </td>
        </tr>
@empty
<tr>
    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
        Belum ada riwayat presensi tersimpan.
    </td>
</tr>
@endforelse
</tbody>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Logika menghitung checkbox
        function updateCounter() {
            const count = document.querySelectorAll('.athlete-checkbox:checked').length;
            document.getElementById('selectedCount').innerText = count;
        }

        document.querySelectorAll('.athlete-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                updateCounter();
                // Toggle warna background row
                if(this.checked) {
                    this.closest('tr').classList.add('bg-blue-50');
                } else {
                    this.closest('tr').classList.remove('bg-blue-50');
                }
            });
        });

        // Search
        document.getElementById('searchAthlete').addEventListener('keyup', function() {
            let filter = this.value.toUpperCase();
            let rows = document.querySelectorAll("#athleteTable tr");
            
            rows.forEach(row => {
                let name = row.querySelector('.font-medium');
                if (name) {
                    let text = name.textContent || name.innerText;
                    row.style.display = text.toUpperCase().indexOf(filter) > -1 ? "" : "none";
                }
            });
        });
    </script>
</body>
</html>