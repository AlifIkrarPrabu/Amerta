<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - D'Amerta Swim</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Latar belakang yang mendekati desain "Plantland" */
            background: linear-gradient(to bottom right, #a7e0d3, #6ed0bf); /* Gradien hijau-biru */
            background-attachment: fixed; /* Latar belakang tetap saat scroll */
        }

        /* Styling untuk input dengan ikon */
        .input-group {
            position: relative;
            margin-bottom: 1.25rem; /* space-y-5 */
        }
        .input-group input {
            padding-left: 3rem; /* Padding untuk ikon */
            padding-right: 1rem;
            padding-top: 0.75rem; /* py-3 */
            padding-bottom: 0.75rem; /* py-3 */
            border: none; /* Hilangkan border default */
            border-radius: 9999px; /* rounded-full */
            background-color: #f0f0f0; /* Latar belakang input sedikit abu-abu */
            width: 100%;
            font-size: 1.125rem; /* text-lg */
            color: #333; /* Warna teks input */
            outline: none; /* Hilangkan outline fokus browser */
            transition: all 0.2s ease-in-out;
        }
        .input-group input:focus {
            background-color: #e0e0e0; /* Sedikit lebih gelap saat fokus */
            box-shadow: 0 0 0 2px #3B82F6; /* Ring fokus biru (contoh) */
        }
        .input-group .icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #888; /* Warna ikon abu-abu */
            pointer-events: none; /* Agar ikon tidak menghalangi klik input */
            z-index: 10;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4">

    {{-- Top Section: Hello! Welcome to D'Amerta Swim --}}
    <div class="w-full max-w-sm text-center mb-8 relative">
        <h1 class="text-4xl md:text-5xl font-bold text-black mb-2 relative z-10">Hello Amertans!</h1>
        <p class="text-lg md:text-xl text-black relative z-10">Welcome to D'Amerta Swim</p>

        {{-- Contoh elemen dekoratif (daun dan pot) --}}
        <div class="absolute -top-12 -left-16 transform rotate-12 text-green-700 opacity-20 hidden md:block">
            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12c0 3.03 1.25 5.76 3.25 7.75C7.25 21.75 9.97 23 12 23c5.52 0 10-4.48 10-10C22 6.48 17.52 2 12 2zM12 21c-4.97 0-9-4.03-9-9s4.03-9 9-9 9 4.03 9 9-4.03 9-9 9zM11 15h2V7h-2v8zM11 17h2v2h-2v-2z"></path></svg>
        </div>
        <div class="absolute -top-4 -right-12">
            <svg class="w-24 h-24 text-white opacity-40" fill="currentColor" viewBox="0 0 24 24"><path d="M21.3 6.3L15.7 0.7c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4L18.6 6H12c-3.3 0-6 2.7-6 6s2.7 6 6 6h1c.5 0 1 .4 1 1s-.4 1-1 1H12c-4.4 0-8-3.6-8-8s3.6-8 8-8h6.6L14.3 2.7c-.4-.4-.4-1 0-1.4s1-.4 1.4 0l5.6 5.6c.4.4.4 1 0 1.4z"></path></svg>
        </div>
    </div>

    {{-- Login Card --}}
    <div class="bg-white p-8 md:p-10 rounded-3xl shadow-lg w-full max-w-md relative -mt-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Login</h2>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Pesan kesalahan (jika ada) --}}
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Email Input --}}
            <div class="input-group">
                <span class="icon">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                    </svg>
                </span>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>

            {{-- Password Input --}}
            <div class="input-group">
                <span class="icon">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm-3-9V6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9z"></path>
                    </svg>
                </span>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>

            {{-- Forgot Password Link --}}
            <div class="text-right text-sm">
                <a href="#" class="text-blue-600 hover:underline font-semibold">Forgot Password?</a>
            </div>

            {{-- Tombol Login --}}
            <button type="submit" class="w-full py-3 mt-4 rounded-full bg-teal-600 text-black text-xl font-bold shadow-md hover:bg-teal-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                Login
            </button>

            {{-- Back to Home--}}
            <div class="text-center text-sm">
                <a href="/" class="text-blue-600 hover:underline font-semibold">Kembali ke Beranda</a>
            </div>
        </form>
    </div>
</body>
</html>
