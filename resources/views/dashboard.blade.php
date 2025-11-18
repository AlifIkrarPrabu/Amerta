<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sederhana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #a7e0d3, #6ed0bf);
            background-attachment: fixed;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4 text-center">
    <div class="bg-white p-8 md:p-10 rounded-3xl shadow-lg w-full max-w-md">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Selamat Datang, {{ $user->name }}!</h1>
        <p class="text-xl text-gray-600 mb-6">Anda telah berhasil login.</p>
        
        <div class="p-6 bg-teal-100 border border-teal-300 rounded-2xl mb-6">
            <p class="text-2xl font-semibold text-teal-800">
                Peran Anda: <span class="uppercase">{{ $user->role }}</span>
            </p>
        </div>
        
        <p class="text-gray-500">Ini adalah halaman sederhana untuk memverifikasi peran Anda setelah login.</p>
        
        <div class="mt-8">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="inline-block px-6 py-3 bg-red-600 text-white rounded-full font-bold shadow-md hover:bg-red-700 transition duration-300">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</body>
</html>
