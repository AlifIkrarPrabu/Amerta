<div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity duration-300"></div>

<aside id="sidebarAthlete" class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-200 flex flex-col min-h-screen shadow-xl transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:flex-shrink-0">
    
    <div class="p-5 border-b border-slate-800 bg-slate-950/40 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <div class="bg-indigo-600 p-2 rounded-xl text-white">
                <i class="fas fa-swimmer fa-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-white tracking-wide text-sm">D'AMERTA SWIM</h1>
                <p class="text-xs text-slate-500 font-medium">Panel Dashboard Atlet</p>
            </div>
        </div>
        <button id="closeSidebarBtn" class="lg:hidden text-slate-400 hover:text-white focus:outline-none p-1.5 hover:bg-slate-800 rounded-lg transition">
            <i class="fas fa-times fa-lg"></i>
        </button>
    </div>
    
    <nav class="flex-1 p-4 space-y-2">
        <a href="{{ route('athlete.dashboard') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition font-medium text-sm {{ Route::is('athlete.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200 group' }}">
            <i class="fas fa-th-large w-5 text-center {{ Route::is('athlete.dashboard') ? '' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
            <span>Dashboard Utama</span>
        </a>

        <a href="{{ route('athlete.attendance-history') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition font-medium text-sm {{ Route::is('athlete.attendance-history') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200 group' }}">
            <i class="fas fa-history w-5 text-center {{ Route::is('athlete.attendance-history') ? '' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
            <span>Riwayat Presensi</span>
        </a>

        <a href="{{ route('athlete.report_detail') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition font-medium text-sm {{ Route::is('athlete.report_detail') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200 group' }}">
            <i class="fas fa-file-invoice w-5 text-center {{ Route::is('athlete.report_detail') ? '' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
            <span>Raport Bulanan</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-800 bg-slate-950/20">
        <div class="flex items-center justify-between">
            <div class="truncate mr-2">
                <p class="text-xs text-slate-500 font-medium">Masuk Sebagai</p>
                <p class="text-sm font-semibold text-slate-300 truncate">{{ Auth::user()->name }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-slate-800 hover:bg-red-950 hover:text-red-400 p-2.5 rounded-xl text-slate-400 transition" title="Keluar">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const hamburgerBtn = document.getElementById("hamburgerBtn");
        const closeSidebarBtn = document.getElementById("closeSidebarBtn");
        const sidebarAthlete = document.getElementById("sidebarAthlete");
        const sidebarOverlay = document.getElementById("sidebarOverlay");

        function openSidebar() {
            sidebarAthlete.classList.remove("-translate-x-full");
            sidebarOverlay.classList.remove("hidden");
        }

        function closeSidebar() {
            sidebarAthlete.classList.add("-translate-x-full");
            sidebarOverlay.classList.add("hidden");
        }

        // Cek jika tombol hamburger dimuat di halaman (karena tombolnya dipindah ke top-bar luar)
        if (hamburgerBtn) {
            hamburgerBtn.addEventListener("click", openSidebar);
        }
        
        closeSidebarBtn.addEventListener("click", closeSidebar);
        sidebarOverlay.addEventListener("click", closeSidebar);
    });
</script>