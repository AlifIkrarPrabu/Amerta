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
            background: linear-gradient(to bottom right, #a7e0d3, #6ed0bf);
            background-attachment: fixed;
        }
        .input-group {
            position: relative;
            margin-bottom: 1.25rem;
        }
        .input-group input {
            padding-left: 3rem;
            padding-right: 1rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            border: none;
            border-radius: 9999px;
            background-color: #f0f0f0;
            width: 100%;
            font-size: 1.125rem;
            color: #333;
            outline: none;
            transition: all 0.2s ease-in-out;
        }
        /* Style untuk input yang memiliki error */
        .input-group input.is-invalid {
            box-shadow: 0 0 0 2px #EF4444; /* Warna merah (Tailwind: red-500) */
        }
        .input-group input:focus {
            background-color: #e0e0e0;
            box-shadow: 0 0 0 2px #3B82F6;
        }
        .input-group .icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            pointer-events: none;
            z-index: 10;
        }
        /* Style untuk ikon mata */
        .password-toggle-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            cursor: pointer;
            z-index: 10;
        }
        .invalid-feedback {
            color: #DC2626; /* Warna merah (Tailwind: red-600) */
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
            margin-left: 1rem;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4">

    {{-- Top Section: Hello! Welcome to D'Amerta Swim --}}
    <div class="w-full max-w-sm text-center mb-8 relative">
        <h1 class="text-4xl md:text-5xl font-bold text-black mb-2 relative z-10">Hello Amertans!</h1>
        <p class="text-lg md:text-xl text-black relative z-10">Welcome To D'Amerta Swim</p>

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

            {{-- Pesan kesalahan (jika ada) - Ini hanya untuk error non-validation/global errors --}}
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Nomor Telepon Input --}}
            <div class="input-group">
                <span class="icon">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.24.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                    </svg>
                </span>
                {{-- PERBAIKAN 1: Mengubah name dan id menjadi phone_number --}}
                <input 
                    type="tel" 
                    id="phone_number" 
                    name="phone_number" 
                    placeholder="Nomor Telepon" 
                    required 
                    value="{{ old('phone_number') }}"
                    class="@error('phone_number') is-invalid @enderror"
                >
            </div>
            
            {{-- PERBAIKAN 2: Menampilkan Error Spesifik untuk Nomor Telepon/Otentikasi --}}
            @error('phone_number')
                <div class="invalid-feedback -mt-4 mb-4" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror

            {{-- Password Input --}}
            <div class="input-group">
                <span class="icon">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm-3-9V6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9z"></path>
                    </svg>
                </span>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Password" 
                    required
                    class="@error('password') is-invalid @enderror"
                >
                {{-- Tombol untuk menampilkan/menyembunyikan password --}}
                <span class="password-toggle-icon" id="togglePassword">
                    {{-- Ikon mata tertutup (default) --}}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.418 0-8.241-2.92-10-7 1.759-4.08 5.582-7 10-7 1.488 0 2.9.21 4.214.619l1.196 1.196-1.196-1.196A10.05 10.05 0 0112 5c-4.418 0-8.241 2.92-10 7 1.759 4.08 5.582 7 10 7 1.488 0 2.9-.21 4.214-.619l-1.196-1.196zm-2.125-2.125l2.25 2.25-2.25-2.25zm0 0l-2.25-2.25m4.5 0l-2.25 2.25m0 0l2.25-2.25M5.625 15.125c1.11 0 2-.89 2-2s-.89-2-2-2-2 .89-2 2 .89 2 2 2z"></path>
                    </svg>
                </span>
            </div>
            {{-- Menampilkan Error Spesifik untuk Password --}}
            @error('password')
                <div class="invalid-feedback -mt-4 mb-4" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror

            {{-- Forgot Password Link --}}
            <div class="text-right text-sm">
                <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline font-semibold">Forgot Password?</a>
            </div>

            {{-- Tombol Login --}}
            <button type="submit"
                class="w-full py-3 mt-4 rounded-full bg-teal-600 text-black text-xl font-bold shadow-md hover:bg-teal-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                Login
            </button>

            {{-- Back to Home--}}
            <div class="text-center text-sm">
                <a href="/" class="text-blue-600 hover:underline font-semibold">Kembali ke Beranda</a>
            </div>
        </form>
    </div>

    {{-- Script untuk fungsi tampil/sembunyi password --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                // Toggle tipe input antara 'password' dan 'text'
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Ganti ikon SVG
                const icon = this.querySelector('svg');
                if (type === 'password') {
                    // Ikon mata tertutup
                    icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.418 0-8.241-2.92-10-7 1.759-4.08 5.582-7 10-7 1.488 0 2.9.21 4.214.619l1.196 1.196-1.196-1.196A10.05 10.05 0 0112 5c-4.418 0-8.241 2.92-10 7 1.759 4.08 5.582 7 10 7 1.488 0 2.9-.21 4.214-.619l-1.196-1.196zm-2.125-2.125l2.25 2.25-2.25-2.25zm0 0l-2.25-2.25m4.5 0l-2.25 2.25m0 0l2.25-2.25M5.625 15.125c1.11 0 2-.89 2-2s-.89-2-2-2-2 .89-2 2 .89 2 2 2z"></path>`;
                } else {
                    // Ikon mata terbuka
                    icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
                }
            });
        });
    </script>

</body>
</html>
