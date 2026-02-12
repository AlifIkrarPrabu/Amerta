<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelatih - Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .month-section { display: none; }
        .month-section.active { display: block; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-user-clock"></i> Presensi Latihan
            </h1>
            <div class="flex items-center gap-4">
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
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center gap-2">
            <span class="text-xs md:text-sm font-bold border-r border-blue-400 pr-3 mr-1 text-gray-600 uppercase tracking-wider">
                Halo, Coach {{ Auth::user()->name ?? 'Pelatih' }}
            </span>
        </div>

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
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Latihan</label>
                                    <input type="date" name="tanggal" required 
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Tempat Latihan</label>
                                    <select name="tempat" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border">
                                        <option value="">Pilih Lokasi</option>
                                        <option value="Pucung">Pucung</option>
                                        <option value="Tirta Santika">Tirta Santika</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1 font-bold">Evaluasi / Catatan Pelatih</label>
                                    <textarea name="evaluation" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2.5 border bg-green-50/30" placeholder="Berikan evaluasi hasil latihan hari ini..."></textarea>
                                    <p class="text-[10px] text-gray-400 mt-1">*Catatan ini akan muncul di dashboard orang tua/atlet.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Daftar Atlet -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full flex flex-col">
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
                            <div class="overflow-x-auto flex-grow">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold sticky top-0">
                                        <tr>
                                            <th class="px-6 py-3 w-16 text-center">Pilih</th>
                                            <th class="px-6 py-3">Nama Lengkap</th>
                                            <th class="px-6 py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="athleteTable" class="divide-y divide-gray-200">
                                        @forelse($athletes as $athlete)
                                        <tr class="hover:bg-blue-50 transition cursor-pointer" onclick="toggleRow(this)">
                                            <td class="px-6 py-4 text-center">
                                                <input type="checkbox" name="athletes[]" value="{{ $athlete->id }}" class="athlete-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" onclick="event.stopPropagation(); updateCounter();">
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
                                        <tr><td colspan="3" class="px-6 py-10 text-center text-gray-500">Tidak ada data atlet tersedia.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-6 bg-gray-50 border-t flex flex-col md:flex-row justify-between items-center gap-4">
                                <div class="text-gray-700">
                                    <span class="text-sm">Total Terpilih:</span>
                                    <span id="selectedCount" class="font-bold text-2xl text-blue-700 ml-2">0</span>
                                </div>
                                <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-10 rounded-lg shadow-lg transition-all transform hover:scale-[1.02]">
                                    Simpan Presensi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <!-- SEKSI RIWAYAT PRESENSI -->
        <section class="mt-12 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-history text-blue-500"></i> Riwayat Presensi
                </h2>
                
                {{-- Dropdown Filter Bulan --}}
                <div class="flex items-center bg-white border border-blue-200 rounded-lg px-3 py-2 shadow-sm focus-within:ring-2 focus-within:ring-blue-500 min-w-[220px]">
                    <i class="fas fa-calendar-check text-blue-500 mr-2"></i>
                    <select id="historyMonthFilter" onchange="filterHistoryMonth(this.value)" class="w-full bg-transparent border-none focus:ring-0 text-gray-700 font-medium cursor-pointer">
                        <option value="all">Semua Riwayat</option>
                        @php
                            $groupedHistory = collect($attendanceHistory ?? [])->groupBy(function($item) {
                                return \Carbon\Carbon::parse($item->tanggal)->translatedFormat('F Y');
                            });
                        @endphp
                        @foreach($groupedHistory as $monthYear => $data)
                            <option value="{{ Str::slug($monthYear) }}">{{ $monthYear }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="historyContainer">
                @forelse($groupedHistory as $monthYear => $items)
                    <div id="history-{{ Str::slug($monthYear) }}" class="month-section active bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                        <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                            <span class="font-bold text-blue-700 uppercase text-sm tracking-widest">{{ $monthYear }}</span>
                            <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded font-bold">{{ $items->count() }} Sesi</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-white text-gray-400 uppercase text-[10px] font-bold">
                                    <tr>
                                        <th class="px-6 py-3 border-b">Tanggal</th>
                                        <th class="px-6 py-3 border-b">Lokasi</th>
                                        <th class="px-6 py-3 border-b">Evaluasi</th>
                                        <th class="px-6 py-3 border-b">Atlet</th>
                                        <th class="px-6 py-3 border-b text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($items as $history)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($history->tanggal)->translatedFormat('d') }}</span>
                                                <span class="text-[10px] text-gray-400 uppercase">{{ \Carbon\Carbon::parse($history->tanggal)->translatedFormat('M Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 italic text-sm">
                                            {{ $history->tempat }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($history->evaluation)
                                                <span class="text-sm text-gray-500 line-clamp-1 italic" title="{{ $history->evaluation }}">
                                                    "{{ Str::limit($history->evaluation, 40) }}"
                                                </span>
                                            @else
                                                <span class="text-[10px] text-gray-300 italic">No notes</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-100 text-blue-700 text-[11px] font-bold px-2 py-0.5 rounded-full">
                                                {{ $history->athletes_count ?? 0 }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('coach.attendance.destroy') }}" method="POST" onsubmit="return confirm('Hapus sesi ini?')">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="tanggal" value="{{ $history->tanggal }}">
                                                <input type="hidden" name="tempat" value="{{ $history->tempat }}">
                                                <button type="submit" class="text-red-400 hover:text-red-600 transition p-2">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-12 rounded-xl border-2 border-dashed text-center text-gray-400">
                        <i class="fas fa-history text-4xl mb-3 block"></i>
                        Belum ada riwayat presensi.
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <script>
        // Filter History by Month
        function filterHistoryMonth(value) {
            const sections = document.querySelectorAll('.month-section');
            if (value === 'all') {
                sections.forEach(s => s.classList.add('active'));
            } else {
                sections.forEach(s => {
                    if (s.id === 'history-' + value) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            }
        }

        // Fungsi Table Selection
        function toggleRow(row) {
            const checkbox = row.querySelector('.athlete-checkbox');
            checkbox.checked = !checkbox.checked;
            updateRowStyle(row, checkbox.checked);
            updateCounter();
        }

        function updateRowStyle(row, isChecked) {
            if(isChecked) {
                row.classList.add('bg-blue-50');
            } else {
                row.classList.remove('bg-blue-50');
            }
        }

        function updateCounter() {
            const count = document.querySelectorAll('.athlete-checkbox:checked').length;
            document.getElementById('selectedCount').innerText = count;
        }

        // Search Atlet
        document.getElementById('searchAthlete').addEventListener('keyup', function() {
            let filter = this.value.toUpperCase();
            let rows = document.querySelectorAll("#athleteTable tr");
            rows.forEach(row => {
                let nameEl = row.querySelector('.font-medium');
                if (nameEl) {
                    let text = nameEl.textContent || nameEl.innerText;
                    row.style.display = text.toUpperCase().indexOf(filter) > -1 ? "" : "none";
                }
            });
        });

        // Event listener checkbox (mencegah bubbling dari click row)
        document.querySelectorAll('.athlete-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                updateRowStyle(this.closest('tr'), this.checked);
            });
        });
    </script>
</body>
</html>