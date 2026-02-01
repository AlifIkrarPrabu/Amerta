<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Atlet - D'Amerta Swim</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }
        .modal {
            transition: opacity 0.25s ease;
        }
        .sidebar-mobile-transition {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-teal-600 shadow-xl flex flex-col p-4 text-white 
             transform -translate-x-full lg:translate-x-0 transition-transform duration-300 lg:static lg:flex lg:min-h-screen sidebar-mobile-transition">
        
        <div class="text-2xl font-bold mb-8 text-center border-b pb-4 border-teal-500">
            D'Amerta Admin
        </div>
        <nav class="flex-grow">
            <ul>
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-xl hover:bg-teal-700 transition duration-150">
                        <i class="fas fa-home mr-3"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.athletes.index') }}" class="flex items-center p-3 rounded-xl bg-teal-700 hover:bg-teal-800 transition duration-150 font-semibold">
                        <i class="fas fa-swimmer mr-3"></i> Kelola Atlet
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 rounded-xl hover:bg-teal-700 transition duration-150">
                        <i class="fas fa-users-cog mr-3"></i> Kelola Akun
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

    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- Main Content --}}
    <main class="flex-1 p-4 sm:p-8">
        <button id="menuButton" class="lg:hidden text-gray-800 text-3xl mb-4" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4 sm:mb-0">Kelola Atlet</h1>
            <button id="openModalBtn" class="bg-teal-600 text-white px-6 py-2 rounded-full font-semibold shadow-md hover:bg-teal-700 transition duration-200 flex items-center w-full sm:w-auto justify-center">
                <i class="fas fa-plus mr-2"></i> Tambah Atlet
            </button>
        </header>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">Gagal memproses data. Mohon periksa kembali.</span>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-6 rounded-2xl shadow-lg overflow-x-auto">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4">Daftar Atlet D'Amerta Swim</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Atlet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Presensi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl. Lahir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($athletes as $index => $athlete)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="font-bold">{{ $athlete->name }}</div>
                                <div class="text-xs text-gray-500">{{ $athlete->phone_number ?? '-' }}</div>
                            </td>
                            
                            {{-- KOLOM TOTAL PRESENSI --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ ($athlete->attendances_count ?? 0) >= 8 ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $athlete->attendances_count ?? 0 }} / 4 Sesi
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $athlete->birth_date?->format('d M Y') ?? '-' }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($athlete->address ?? '-', 20) }}</td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                {{-- TOMBOL RESET PRESENSI (SETELAH BAYAR) --}}
                                <form action="{{ route('admin.athletes.reset-attendance', $athlete->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Konfirmasi: Atlet ini sudah membayar dan presensi akan direset ke 0?')">
                                    @csrf
                                    <button type="submit" class="text-emerald-600 hover:text-emerald-900 mx-1 p-2 rounded-full hover:bg-emerald-50 transition duration-150" title="Reset Presensi (Sudah Bayar)">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </button>
                                </form>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.athletes.destroy', $athlete->id) }}" method="POST" class="inline-block" onsubmit="return showConfirmDelete(event);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 mx-1 p-2 rounded-full hover:bg-red-50 transition duration-150" title="Hapus Atlet">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data atlet yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    {{-- Modal Tambah Atlet --}}
    <div id="athleteModal" class="modal fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center opacity-0 pointer-events-none p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform transition-transform duration-300 scale-95">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Tambah Atlet Baru</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 text-3xl">&times;</button>
            </div>
            
            <form action="{{ route('admin.athletes.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                    <input type="tel" id="phone_number" name="phone_number" required value="{{ old('phone_number') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="mb-4">
                    <label for="birth_date" class="block text-gray-700 font-semibold mb-2">Tanggal Lahir</label>
                    <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-semibold mb-2">Alamat</label>
                    <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">{{ old('address') }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                </div>
                
                <button type="submit" class="w-full bg-teal-600 text-white py-3 rounded-xl font-bold hover:bg-teal-700 transition duration-200 shadow-lg">
                    Simpan Atlet
                </button>
            </form>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div id="confirmModal" class="modal fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center opacity-0 pointer-events-none p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 transform transition-transform duration-300 scale-95">
            <h3 class="text-xl font-bold text-red-600 mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus atlet ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-end space-x-3">
                <button id="cancelDeleteBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-150">Batal</button>
                <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-150">Hapus</button>
            </div>
        </div>
    </div>

    <script>
        // --- Sidebar Logic ---
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        let isSidebarOpen = false;

        function toggleSidebar() {
            isSidebarOpen = !isSidebarOpen;
            if (isSidebarOpen) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
        
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024 && isSidebarOpen) {
                isSidebarOpen = false;
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });

        // --- Modal Tambah Logic ---
        const modal = document.getElementById('athleteModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');

        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.querySelector('div').classList.add('scale-100');
        });

        closeModalBtn.addEventListener('click', () => {
            modal.querySelector('div').classList.remove('scale-100');
            setTimeout(() => { modal.classList.add('opacity-0', 'pointer-events-none'); }, 300);
        });

        if (@json($errors->any())) {
            window.onload = function() {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.querySelector('div').classList.add('scale-100');
            };
        }

        // --- Modal Hapus Logic ---
        const confirmModal = document.getElementById('confirmModal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        let formToSubmit = null;

        function showConfirmDelete(event) {
            event.preventDefault();
            formToSubmit = event.target;
            confirmModal.classList.remove('opacity-0', 'pointer-events-none');
            confirmModal.querySelector('div').classList.add('scale-100');
            return false;
        }

        cancelDeleteBtn.addEventListener('click', () => {
            confirmModal.querySelector('div').classList.remove('scale-100');
            setTimeout(() => { confirmModal.classList.add('opacity-0', 'pointer-events-none'); }, 300);
        });

        confirmDeleteBtn.addEventListener('click', () => {
            if (formToSubmit) formToSubmit.submit();
        });
    </script>
</body>
</html>