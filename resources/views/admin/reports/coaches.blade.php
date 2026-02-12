<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelatih - D'Amerta Swim</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; }
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
        .month-content { display: none; }
        .month-content.active { display: block; }
    </style>
</head>
<body class="flex min-h-screen overflow-x-hidden">

    {{-- Sidebar Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-teal-600 shadow-xl flex flex-col p-4 text-white transform -translate-x-full lg:translate-x-0 sidebar-transition lg:static lg:flex lg:min-h-screen">
        <div class="flex items-center justify-between mb-8 border-b pb-4 border-teal-500">
            <div class="text-2xl font-bold text-center w-full">D'Amerta Admin</div>
            <button class="lg:hidden" onclick="toggleSidebar()"><i class="fas fa-times"></i></button>
        </div>
        <nav class="flex-grow">
            <ul>
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-xl hover:bg-teal-700 transition duration-150">
                        <i class="fas fa-home mr-3"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.athletes.index') }}" class="flex items-center p-3 rounded-xl hover:bg-teal-700 transition duration-150">
                        <i class="fas fa-swimmer mr-3"></i> Kelola Atlet
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 rounded-xl {{ Request::routeIs('admin.users.*') ? 'bg-teal-700' : 'hover:bg-teal-700' }} transition duration-150">
                        <i class="fas fa-users-cog mr-3"></i> Kelola Akun
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.reports.coaches') }}" class="flex items-center p-3 rounded-xl bg-teal-700 font-semibold transition duration-150">
                        <i class="fas fa-clipboard-list mr-3"></i> Reports Coach
                    </a>
                </li>
            </ul>
        </nav>
        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center p-3 rounded-xl bg-red-600 hover:bg-red-700 font-semibold shadow-lg">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-4 md:p-8 w-full">
        <header class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
            <div class="flex items-center">
                <button onclick="toggleSidebar()" class="lg:hidden mr-4 text-teal-600 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Laporan Aktivitas Pelatih</h1>
            </div>

            {{-- Filter Bulan --}}
            <div class="relative min-w-[200px]">
                <label for="monthFilter" class="block text-xs font-semibold text-gray-500 uppercase mb-1 ml-1">Pilih Periode Laporan:</label>
                <div class="flex items-center bg-white border border-teal-200 rounded-xl px-3 py-2 shadow-sm focus-within:ring-2 focus-within:ring-teal-500 transition">
                    <i class="fas fa-filter text-teal-500 mr-2"></i>
                    <select id="monthFilter" onchange="filterMonth(this.value)" class="w-full bg-transparent border-none focus:ring-0 text-gray-700 font-medium cursor-pointer appearance-none">
                        <option value="all">Semua Bulan</option>
                        @php
                            $groupedReports = $reports->groupBy(function($item) {
                                return \Carbon\Carbon::parse($item->tanggal)->translatedFormat('F Y');
                            });
                        @endphp
                        @foreach($groupedReports as $monthYear => $items)
                            <option value="{{ Str::slug($monthYear) }}">{{ $monthYear }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down text-gray-400 ml-2 pointer-events-none"></i>
                </div>
            </div>
        </header>

        <div id="reportsContainer" class="space-y-10">
            @forelse($groupedReports as $monthYear => $items)
                <div id="content-{{ Str::slug($monthYear) }}" class="month-content active bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300">
                    {{-- Header Bulan --}}
                    <div class="p-4 border-b border-teal-100 flex justify-between items-center bg-teal-600 text-white">
                        <h3 class="font-bold flex items-center gap-2 text-lg">
                            <i class="fas fa-calendar-alt"></i> {{ $monthYear }}
                        </h3>
                        <span class="bg-teal-800 text-xs px-3 py-1 rounded-full">{{ $items->count() }} Sesi</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 text-xs uppercase font-bold tracking-wider">
                                    <th class="p-4 border-b">Tanggal</th>
                                    <th class="p-4 border-b">Pelatih</th>
                                    <th class="p-4 border-b">Materi / Tempat</th>
                                    <th class="p-4 border-b text-center">Jumlah Atlet</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 divide-y divide-gray-100">
                                @foreach($items as $report)
                                <tr class="hover:bg-teal-50/50 transition">
                                    <td class="p-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($report->tanggal)->translatedFormat('d') }}</span>
                                            <span class="text-xs text-gray-400 uppercase">{{ \Carbon\Carbon::parse($report->tanggal)->translatedFormat('D') }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-teal-700">{{ $report->coach->name ?? 'Pelatih' }}</span>
                                            <span class="text-xs text-gray-400">{{ $report->coach->phone_number ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-medium text-gray-800">{{ $report->materi ?? 'Tanpa Materi' }}</p>
                                        <p class="text-[10px] text-gray-400 flex items-center gap-1 mt-1 uppercase">
                                            <i class="fas fa-map-marker-alt text-red-400"></i> {{ $report->tempat }}
                                        </p>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg font-bold text-sm">
                                            {{ $report->total_atlet }} <span class="hidden md:inline">Atlet</span>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="bg-white p-20 rounded-2xl shadow text-center border-2 border-dashed border-gray-200">
                    <i class="fas fa-folder-open text-5xl text-gray-200 mb-4"></i>
                    <p class="text-gray-400">Belum ada data laporan aktivitas pelatih.</p>
                </div>
            @endforelse
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function filterMonth(value) {
            const contents = document.querySelectorAll('.month-content');
            
            if (value === 'all') {
                contents.forEach(content => {
                    content.classList.add('active');
                });
            } else {
                contents.forEach(content => {
                    if (content.id === 'content-' + value) {
                        content.classList.add('active');
                    } else {
                        content.classList.remove('active');
                    }
                });
            }
        }
    </script>
</body>
</html>