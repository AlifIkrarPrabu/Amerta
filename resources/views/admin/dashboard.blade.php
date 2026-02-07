<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - D'Amerta Swim</title>
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
            {{-- Tombol Tutup Sidebar (Hanya Mobile) --}}
            <button class="lg:hidden text-white" onclick="toggleSidebar()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <nav class="flex-grow">
            <ul>
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-xl {{ Request::routeIs('admin.dashboard') ? 'bg-teal-700 font-semibold' : 'hover:bg-teal-700' }} transition duration-150">
                        <i class="fas fa-home mr-3"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.athletes.index') }}" class="flex items-center p-3 rounded-xl {{ Request::routeIs('admin.athletes.*') ? 'bg-teal-700 font-semibold' : 'hover:bg-teal-700' }} transition duration-150">
                        <i class="fas fa-swimmer mr-3"></i> Kelola Atlet
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 rounded-xl {{ Request::routeIs('admin.users.*') ? 'bg-teal-700 font-semibold' : 'hover:bg-teal-700' }} transition duration-150">
                        <i class="fas fa-users-cog mr-3"></i> Kelola Akun
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.reports.coaches') }}" class="flex items-center p-3 rounded-xl {{ Request::routeIs('admin.reports.coaches') ? 'bg-teal-700 font-semibold' : 'hover:bg-teal-700' }} transition duration-150">
                        <i class="fas fa-clipboard-list mr-3"></i> Reports Coach
                    </a>
                </li>
            </ul>
        </nav>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center p-3 rounded-xl bg-red-600 hover:bg-red-700 font-semibold shadow-lg transition">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-4 md:p-8 w-full">
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center">
                {{-- Tombol Hamburger (Hanya tampil di Mobile) --}}
                <button onclick="toggleSidebar()" class="lg:hidden mr-4 text-teal-600 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Dashboard Utama</h1>
            </div>
            <div class="hidden md:block text-right">
                <p class="text-gray-500 text-sm">Halo, Admin!</p>
                <p class="font-bold text-teal-600">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card 1: Total Atlet (Contoh) --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-teal-500">
                <div class="flex items-center">
                    <div class="p-3 bg-teal-100 rounded-full mr-4">
                        <i class="fas fa-users text-teal-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Atlet</p>
                        <p class="text-3xl font-bold text-gray-900">125</p>
                    </div>
                </div>
            </div>

            {{-- Card 2: Kelas Aktif (Contoh) --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full mr-4">
                        <i class="fas fa-swimmer text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Kelas Aktif</p>
                        <p class="text-3xl font-bold text-gray-900">15</p>
                    </div>
                </div>
            </div>

            {{-- Card 3: Pendapatan Bulan Ini (Contoh) --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full mr-4">
                        <i class="fas fa-dollar-sign text-yellow-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pendapatan Bulan Ini</p>
                        <p class="text-3xl font-bold text-gray-900">Rp 12.500.000</p>
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-10 bg-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Akses Cepat</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.athletes.index') }}" class="text-center p-6 bg-gray-50 rounded-xl hover:bg-teal-100 transition duration-150 shadow">
                    <i class="fas fa-user-plus text-4xl text-teal-600 mb-2"></i>
                    <p class="font-medium">Tambah Atlet</p>
                </a>
                <a href="{{ route('admin.athletes.index') }}" class="text-center p-6 bg-gray-50 rounded-xl hover:bg-teal-100 transition duration-150 shadow">
                    <i class="fas fa-table text-4xl text-teal-600 mb-2"></i>
                    <p class="font-medium">Daftar Atlet</p>
                </a>
                <a href="#" class="text-center p-6 bg-gray-50 rounded-xl hover:bg-teal-100 transition duration-150 shadow opacity-50 cursor-not-allowed">
                    <i class="fas fa-calendar-alt text-4xl text-teal-600 mb-2"></i>
                    <p class="font-medium">Jadwal Latihan</p>
                </a>
                <a href="#" class="text-center p-6 bg-gray-50 rounded-xl hover:bg-teal-100 transition duration-150 shadow opacity-50 cursor-not-allowed">
                    <i class="fas fa-file-invoice-dollar text-4xl text-teal-600 mb-2"></i>
                    <p class="font-medium">Kelola Pembayaran</p>
                </a>
            </div>
        </section>

    </main>
<script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            // Toggle class translate untuk geser sidebar
            sidebar.classList.toggle('-translate-x-full');
            // Toggle overlay hitam
            overlay.classList.toggle('hidden');
        }
</script>
</body>
</html>
