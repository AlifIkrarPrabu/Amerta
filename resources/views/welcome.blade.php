<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D'Amerta Swim - Professional Diving Trainings</title>
    {{-- Menggunakan Vite untuk mengkompilasi CSS dan JS Anda --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Menambahkan Google Fonts 'Poppins' --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden; /* Mencegah scroll horizontal yang tidak diinginkan */
        }
        /* Style untuk latar belakang hero section dengan gambar */
        .hero-background {
            background-image: url('{{ asset('images/logo.jpg') }}'); /* Ganti dengan nama file gambar hero Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }
        .hero-background::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to right, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0) 100%); /* Overlay gelap */
        }
        /* Style untuk gambar lingkaran */
        .circular-image {
            background-image: url('{{ asset('images/circular-diver.jpg') }}'); /* Ganti dengan nama file gambar lingkaran Anda */
            background-size: cover;
            background-position: center;
            border-radius: 50%; /* Membuat gambar menjadi lingkaran */
            overflow: hidden;
            border: 10px solid #e0f2fe; /* Warna border biru muda */
            box-shadow: 0 0 0 10px #bfdbfe; /* Warna shadow biru yang lebih gelap */
            transform: scale(1.05); /* Sedikit membesar untuk efek */
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Memanggil komponen header -->
    @include('components.header')

    {{-- Hero Section --}}
    <section class="hero-background text-white py-24 md:py-48 flex items-center min-h-[600px]">
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-xl">
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-4">
                    Professional <br> Swimming Club
                </h1>
                <p class="text-xl md:text-2xl mb-8">
                    Where Champions Begin!
                </p>
                <a href="{{ route('login') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-full text-lg shadow-lg transition duration-300">
    LOGIN &rarr;
</a>
            </div>
        </div>
    </section>

    {{-- Feature Section --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            {{-- Feature 1: Expert Staff --}}
            <div class="p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <div class="text-blue-600 mb-4 text-5xl">
                    {{-- Ganti dengan ikon helm atau sejenisnya --}}
                    👨🏼‍💼
                </div>
                <h3 class="text-xl font-semibold mb-2">Pelatih Profesional</h3>
                <p class="text-gray-600">
                   Kami siap melayani Anda dengan tim hebat yang mampu memberikan pelatihan terbaik.
                </p>
            </div>
            {{-- Feature 2: Education & Discipline --}}
            <div class="p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <div class="text-blue-600 mb-4 text-5xl">
                    {{-- Ganti dengan ikon tetesan air atau buku --}}
                    👶🏻👨🏻‍🦰
                </div>
                <h3 class="text-xl font-semibold mb-2">Bebas Usia</h3>
                <p class="text-gray-600">
                    Kami mewujudkan impian Anda dengan menyediakan pelatihan renang profesional untuk semua kalangan.
                </p>
            </div>
            {{-- Feature 3: Structuring --}}
            <div class="p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <div class="text-blue-600 mb-4 text-5xl">
                    {{-- Ganti dengan ikon gigi roda atau bangunan --}}
                    ⚙️
                </div>
                <h3 class="text-xl font-semibold mb-2">Penyusunan Program</h3>
                <p class="text-gray-600">
                   Kami menciptakan perenang profesional melalui program pelatihan yang sistematis dan disesuaikan.
                </p>
            </div>
            {{-- Feature 4: Professional Service --}}
            <div class="p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <div class="text-blue-600 mb-4 text-5xl">
                    {{-- Ganti dengan ikon jabat tangan atau jempol --}}
                    👍
                </div>
                <h3 class="text-xl font-semibold mb-2">Layanan Profesional</h3>
                <p class="text-gray-600">
                    Tim kami secara profesional berdedikasi untuk membantu Anda mencapai tujuan renang Anda
                </p>
            </div>
        </div>
    </section>

    {{-- About / CTA Section --}}
    <section class="py-16 bg-blue-50">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-12">
            <div class="w-full md:w-1/2 flex justify-center items-center">
            </div>
            <div class="w-full md:w-1/2 text-center md:text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-800 mb-6">
                    Apakah Anda ingin menjadi perenang profesional?
                </h2>
                <p class="text-gray-700 text-lg mb-6">
                    Rasakan pengalaman berenang yang seru dan penuh makna di setiap sesi latihan. Kini, kami ingin memberi Anda kesempatan untuk berenang lebih dalam, lebih fokus, dan lebih profesional di jalur menuju prestasi.
                </p>

                <div class="space-y-4 mb-8">
                    <div class="flex items-center text-gray-800 text-lg">
                        Bersama pelatih berpengalaman dan program yang terstruktur, kami percaya bahwa setiap anak memiliki potensi untuk tumbuh menjadi atlet renang yang tangguh dan berkarakter. Latihan tidak hanya soal teknik, tapi juga kedisiplinan, kerja sama, dan semangat pantang menyerah. Semua itu dibangun secara konsisten dalam suasana yang mendukung dan menyenangkan.

                    </div>
                    <div class="flex items-center text-gray-800 text-lg">
                        D'Amerta Swim hadir bukan hanya sebagai tempat belajar berenang, tapi sebagai wadah pembentukan karakter dan jiwa kompetitif yang sehat. Bergabunglah bersama kami, dan jadilah bagian dari generasi perenang yang siap mencetak prestasi dan menginspirasi banyak orang.
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Training Section --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-blue-800 mb-3">Our Professional Swimming Training</h2>
            <p class="text-gray-600 text-lg mb-10">Temukan dunia renang yang penuh misteri bersama kami.</p>

            <main class="flex flex-col md:flex-row justify-center items-center gap-8 px-4 w-full max-w-6xl">
        <!-- Kartu Privat Class -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full md:w-1/2 lg:w-1/3 flex flex-col">
            <img src="{{ asset('images/reguler.jpg') }}" alt="Privat Class" class="w-full h-56 object-cover">
            <div class="p-6 flex-grow flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Privat Class</h2>
                    <p class="text-gray-600">Swimming courses are for anyone who isn't afraid of water. Experience a new world.</p>
                </div>
            </div>
        </div>

        <!-- Kartu Regular Class -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full md:w-1/2 lg:w-1/3 flex flex-col">
            <img src="{{ asset('images/privat.jpg') }}" alt="Privat Class" class="w-full h-56 object-cover">
            <div class="p-6 flex-grow flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Regular Class</h2>
                    <p class="text-gray-600">In places with less human impact, such as lakes, or after sunset, your diving adventure does not have to end.</p>
                </div>
            </div>
        </div>
    </main>
        </div>
    </section>

    <!-- Memanggil komponen footer -->
    @include('components.footer')

</body>
</html>