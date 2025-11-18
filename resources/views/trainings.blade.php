<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Trainings - D'Amera Swim</title>
    <!-- Memuat Tailwind CSS dari CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Konfigurasi Tailwind CSS untuk font Inter -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <!-- Memuat font Inter dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Memanggil komponen header -->
    @include('components.header')

    <main class="text-center text-red-70">
        <p class="text-xl">Informasi lebih lanjut tentang pendaftaran akan hadir di sini!</p>
        <!-- Anda bisa menambahkan konten spesifik pelatihan di sini -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8 max-w-4xl mx-auto">
            <!-- Contoh Kartu Pelatihan 1 -->
            <div class="bg-blue-50 rounded-xl shadow-lg p-6 flex flex-col items-center text-center">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Kelas Reguler</h3>
                <img src="{{ asset('images/reguler.jpg') }}"
                     onerror="this.onerror=null;this.src='https://placehold.co/300x200/A0A0A0/FFFFFF?text=Gambar+Tidak+Tersedia';"
                     alt="Pelatihan Pemula" class="w-full h-36 object-cover rounded-md mb-4">
                <p class="text-gray-600 mb-4">Dirancang untuk mereka yang ingin latihan dengan kebersamaan</p>
                <a href="https://wa.me/+6283804665952" class="mt-auto inline-block bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 transition duration-300">
                    Tanya Admin Yuk
                </a>
            </div>

            <!-- Contoh Kartu Pelatihan 2 -->
            <div class="bg-blue-50 rounded-xl shadow-lg p-6 flex flex-col items-center text-center">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Kelas Privat</h3>
                <img src="{{ asset('images/privat.jpg') }}"
                     onerror="this.onerror=null;this.src='https://placehold.co/300x200/B0B0B0/FFFFFF?text=Gambar+Tidak+Tersedia';"
                     alt="Pelatihan Menengah" class="w-full h-36 object-cover rounded-md mb-4">
                <p class="text-gray-600 mb-4">Kelas ini bersifat eksklusif karena hanya diikuti oleh satu anak dengan satu pelatih khusus, maka anak mendapatkan akses lebih luas</p>
                <a href="https://wa.me/+6283804665952" class="mt-auto inline-block bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 transition duration-300">
                    Tanya Admin Yuk
                </a>
            </div>

            <!-- Contoh Kartu Pelatihan 3 -->
            <div class="bg-blue-50 rounded-xl shadow-lg p-6 flex flex-col items-center text-center">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Kelas Semi Privat</h3>
                <img src="{{ asset('images/semiprivat.jpg') }}"
                     onerror="this.onerror=null;this.src='https://placehold.co/300x200/C0C0C0/FFFFFF?text=Gambar+Tidak+Tersedia';"
                     alt="Pelatihan Lanjutan" class="w-full h-36 object-cover rounded-md mb-4">
                <p class="text-gray-600 mb-4">Kelas ini sama seperti kelas privat tetapi kelas ini bisa di ikuti oleh 2 sampai 3 anak per latihan</p>
                <a href="https://wa.me/+6283804665952" class="mt-auto inline-block bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 transition duration-300">
                    Tanya Admin Yuk
                </a>
            </div>
        </div>
    </main>

    <!-- Memanggil komponen footer -->
    @include('components.footer')

</body>
</html>
