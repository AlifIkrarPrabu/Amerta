<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - D'Amerta Swim</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Icon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }
    </style>
</head>
<body class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-teal-600 shadow-xl flex flex-col p-4 text-white">
        <div class="text-2xl font-bold mb-8 text-center border-b pb-4 border-teal-500">
            D'Amerta Admin
        </div>
        <nav class="flex-grow">
            <ul>
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-xl bg-teal-700 hover:bg-teal-800 transition duration-150 font-semibold">
                        <i class="fas fa-home mr-3"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.athletes.index') }}" class="flex items-center p-3 rounded-xl hover:bg-teal-700 transition duration-150">
                        <i class="fas fa-users mr-3"></i> Kelola Atlet
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="flex items-center p-3 rounded-xl hover:bg-teal-700 transition duration-150 opacity-50 cursor-not-allowed">
                        <i class="fas fa-chart-line mr-3"></i> Laporan (Soon)
                    </a>
                </li>
            </ul>
        </nav>
        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center p-3 rounded-xl bg-red-600 hover:bg-red-700 transition duration-150 font-semibold shadow-lg">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800">Dashboard Utama</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Halo, {{ Auth::user()->name ?? 'Admin' }}!</span>
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

</body>
</html>
