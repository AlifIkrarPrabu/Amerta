<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - D'Amerta Swim</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh; /* Agar footer selalu di bawah jika konten sedikit */
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1; /* Konten utama mengisi ruang yang tersisa */
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Memanggil komponen header -->
    @include('components.header')

    {{-- Main Content for About Us Page --}}
    <main class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-blue-800 text-center mb-8">About D'Amerta Swim</h1>

            <div class="flex flex-col md:flex-row items-center gap-12 mb-12">
                <div class="md:w-1/2">
                    <img src="{{ asset('images/logo.jpg') }}" alt="About Us Image" class="rounded-lg shadow-lg">
                </div>
                <div class="md:w-1/2 text-gray-700 text-lg leading-relaxed">
                    <p class="mb-4">
                        D'Amerta Swim adalah klub renang profesional yang berfokus pada pengembangan kemampuan renang dari tingkat dasar hingga lanjutan. Didirikan pada 22 Januari 2025, mulai dari anak-anak hingga remaja dan dewasa, dengan pendekatan yang terstruktur, aman, dan menyenangkan.
                    </p>
                    <p class="mb-4">
                        Misi kami adalah mencetak perenang yang tangguh, percaya diri, dan memiliki semangat sportivitas tinggi baik untuk kebutuhan rekreasi maupun prestasi. Kami percaya bahwa setiap individu memiliki potensi luar biasa untuk berkembang di air, dan kami siap mendampingi perjalanan tersebut dari awal hingga mahir.
                    </p>
                    <p>
                        Tim pelatih kami terdiri dari profesional bersertifikat dan berpengalaman, yang tidak hanya menguasai teknik renang secara menyeluruh, tapi juga mampu menciptakan suasana latihan yang positif dan membangun. Bergabunglah dengan D'Amerta Swim, dan jadilah bagian dari komunitas renang yang solid, fokus, dan inspiratif!
                    </p>
                </div>
            </div>

            <div class="text-center mt-12">
                <h2 class="text-3xl font-bold text-blue-800 mb-6">Our Values</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 bg-blue-50 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-blue-700 mb-2">Safety First</h3>
                        <p class="text-gray-600 text-sm">Keselamatan adalah prioritas utama kami dalam setiap sesi latihan.</p>
                    </div>
                    <div class="p-6 bg-blue-50 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-blue-700 mb-2">Professionalism</h3>
                        <p class="text-gray-600 text-sm">Kami menjunjung tinggi standar profesionalisme dalam pengajaran dan layanan kami.</p>
                    </div>
                    <div class="p-6 bg-blue-50 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-blue-700 mb-2">Passionate about swimming</h3>
                        <p class="text-gray-600 text-sm">Kami menanamkan kecintaan dan rasa hormat terhadap air serta pentingnya menjaga lingkungan sekitar kolam dan perairan alami.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Memanggil komponen footer -->
    @include('components.footer')

</body>
</html>