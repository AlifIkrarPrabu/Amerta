{{-- Footer Section --}}
    <footer class="bg-blue-900 text-white py-12">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- About D'Amerta Swim --}}
            <div>
                <h3 class="text-xl font-bold mb-4">D'Amerta Swim</h3>
                <p class="text-gray-300 text-sm mb-4">
                   D'Amerta Swim adalah klub renang profesional yang berfokus pada pengembangan kemampuan renang dari tingkat dasar hingga lanjutan.
                </p>
                <div class="flex space-x-4">
                    <!-- Ikon Facebook dari gambar -->
                    <a href="https://www.facebook.com/profile.php?id=61572535635719" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white transition duration-300">
                        <img src="{{ asset('images/fb.png') }}" alt="Facebook" class="w-6 h-6">
                    </a>

                    <!-- Ikon Instagram dari gambar -->
                    <a href="https://www.instagram.com/d.amertaswim?igsh=MWlmcHNpMTd6bHRs" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white transition duration-300">
                        <img src="{{ asset('images/ig.png') }}" alt="Instagram" class="w-6 h-6">
                    </a>

                    <!-- Ikon TikTok dari gambar -->
                    <a href="https://www.tiktok.com/@damerta.swim?_t=ZS-8yTsybmnugZ&_r=1" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white transition duration-300">
                        <img src="{{ asset('images/tiktok.png') }}" alt="TikTok" class="w-6 h-6">
                    </a>

                    <!-- Ikon WhatsApp dari gambar -->
                    <a href="https://wa.me/+6283804665952" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white transition duration-300">
                        <img src="{{ asset('images/wa.png') }}" alt="WhatsApp" class="w-6 h-6">
                    </a>
                </div>
            </div>

            {{-- Useful Links --}}
            <div>
                <h3 class="text-xl font-bold mb-4">Link Berguna</h3>
                <ul class="space-y-2 text-gray-300 text-sm">
                    <li><a href="/" class="hover:text-white">Beranda</a></li>
                    <li><a href="about" class="hover:text-white">Tentang Kami</a></li>
                    <li><a href="trainings" class="hover:text-white">Pelatihan</a></li>
                </ul>
            </div>

            {{-- Recent Posts (Placeholder) --}}
            <div>
                <h3 class="text-xl font-bold mb-4">Berita Terbaru</h3>
                <ul class="space-y-4 text-gray-300 text-sm">
                    <li>
                        <a href="https://www.instagram.com/p/DJrD9AHzX19/?igsh=Mm9tZzhzMHI2eG1x" class="block hover:text-white">
                            <span class="font-semibold">Tips Memilih Kelas Renang</span><br>
                            <span class="text-xs text-gray-400">30 Juli 2025</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/p/DJlNZ-FTRej/?igsh=NGN0ZzZhOWlhM3pl" class="block hover:text-white">
                            <span class="font-semibold">Ini dia Manfaat Renang Untuk Anda</span><br>
                            <span class="text-xs text-gray-400">10 Juli 2025</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contact Info --}}
            <div>
                <h3 class="text-xl font-bold mb-4">Hubungi Kami</h3>
                <ul class="space-y-2 text-gray-300 text-sm">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg>
                        C4, Jl. Mashudi No.30, Pucung, Kota Baru, Karawang, West Java 41374
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.24.2 2.45.57 3.57.11.35.02.75-.25 1.02L6.62 10.79z"></path></svg>
                        +62 838-0466-5952
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path></svg>
                        swimamerta@gmail.com
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} D'Amerta Swim. All rights reserved. Developed by Amerta Team.
        </div>
    </footer>
