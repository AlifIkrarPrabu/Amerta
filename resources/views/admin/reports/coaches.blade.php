<!DOCTYPE html>
<html lang="en">
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
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center">
                <button onclick="toggleSidebar()" class="lg:hidden mr-4 text-teal-600 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Laporan Aktivitas Pelatih</h1>
            </div>
        </header>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-teal-50">
                <h3 class="font-bold text-teal-800">Riwayat Sesi Latihan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm uppercase">
                            <th class="p-4 border-b">Tanggal</th>
                            <th class="p-4 border-b">Pelatih</th>
                            <th class="p-4 border-b">Materi / Tempat</th>
                            <th class="p-4 border-b text-center">Jumlah Atlet</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 border-b">
                                <span class="font-semibold">{{ \Carbon\Carbon::parse($report->tanggal)->translatedFormat('d M Y') }}</span>
                            </td>
                            <td class="p-4 border-b">
                                <div class="flex flex-col">
                                    <span class="font-bold text-teal-700">{{ $report->coach->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $report->coach->phone_number }}</span>
                                </div>
                            </td>
                            <td class="p-4 border-b">
                                <p class="font-medium text-gray-800">{{ $report->materi ?? 'Tanpa Materi' }}</p>
                                <p class="text-xs text-gray-400"><i class="fas fa-map-marker-alt mr-1"></i> {{ $report->tempat }}</p>
                            </td>
                            <td class="p-4 border-b text-center">
                                <span class="px-4 py-1 bg-blue-100 text-blue-700 rounded-full font-bold">
                                    {{ $report->total_atlet }} Atlet
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-10 text-center text-gray-400">Belum ada data latihan yang diinput.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>