{{-- resources/views/components/header.blade.php --}}

<header class="w-full bg-white shadow-md py-4 px-6 md:px-8 flex items-center justify-between relative">
    <!-- Logo -->
    <div class="flex items-center">
        <img src="{{ asset('images/logo.jpg') }}" alt="D'Amerta Swim Logo" class="h-10 w-10 rounded-full mr-3">
        <span class="text-xl font-bold text-blue-800">D'Amerta Swim</span>
    </div>

    <!-- Tombol Hamburger (Hanya terlihat di Mobile) -->
    <button id="mobile-menu-button" class="md:hidden p-2 text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <!-- Navigasi Desktop dan Mobile Menu -->
    <nav id="mobile-menu" class="hidden md:flex flex-col md:flex-row items-start md:items-center justify-start md:justify-center absolute md:static top-full left-0 w-full md:w-auto bg-white md:bg-transparent shadow-lg md:shadow-none py-4 md:py-0 z-50 px-4">
        <a href="{{ route('welcome') }}" class="block md:inline-block text-gray-700 hover:text-blue-600 font-semibold py-2 px-4 md:px-3 transition duration-300">Home</a>
        <a href="{{ route('about') }}" class="block md:inline-block text-gray-700 hover:text-blue-600 font-semibold py-2 px-4 md:px-3 transition duration-300">About Us</a>
        <a href="{{ route('trainings') }}" class="block md:inline-block text-gray-700 hover:text-blue-600 font-semibold py-2 px-4 md:px-3 transition duration-300">Trainings</a>

        <!-- Tombol Upcoming Events (Terlihat di Desktop, di bawah menu di Mobile) -->
        <a href="{{ url('/upcoming-events') }}" class="block w-full md:inline-flex md:w-auto items-center justify-center bg-blue-600 text-white font-semibold py-3 px-5 rounded-full shadow-md hover:bg-blue-700 transition duration-300 mt-4 md:mt-0 md:ml-6">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 002-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
            Upcoming Events
        </a>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('flex');
            // Pastikan flex-col selalu ada saat menu mobile aktif
            mobileMenu.classList.add('flex-col');
            mobileMenu.classList.remove('md:flex-row'); // Pastikan ini tidak mengganggu
        });

        // Menutup menu jika mengklik di luar area menu (opsional)
        document.addEventListener('click', function(event) {
            const isClickInsideMenu = mobileMenu.contains(event.target) || mobileMenuButton.contains(event.target);
            if (!isClickInsideMenu && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('flex');
                mobileMenu.classList.remove('flex-col');
            }
        });
    });
</script>
