<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun - D'Amerta Swim</title>
    <!-- Tambahkan CSRF Token di head untuk AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }
        /* Style untuk modal custom (Tailwind only) */
        .modal {
            transition: opacity 0.25s ease;
        }
        .modal-content {
            transition: transform 0.3s ease-in-out;
        }
        .sidebar-mobile-transition {
            transition: transform 0.3s ease-in-out;
        }
    </style>
    <!-- Memastikan JQuery dimuat untuk fungsionalitas AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <a href="{{ route('admin.athletes.index') }}" class="flex items-center p-3 rounded-xl hover:bg-teal-700 transition duration-150">
                        <i class="fas fa-swimmer mr-3"></i> Kelola Atlet
                    </a>
                </li>
                   <li class="mb-2">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 rounded-xl bg-teal-700 hover:bg-teal-800 transition duration-150 font-semibold">
                        <i class="fas fa-user-lock mr-3"></i> Kelola Akun
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.reports.coaches') }}" class="flex items-center p-3 rounded-xl {{ Request::routeIs('admin.reports.coaches') ? 'bg-teal-700' : 'hover:bg-teal-700' }} transition duration-150">
                        <i class="fas fa-file-signature mr-3"></i> Reports Coach
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

    {{-- Overlay untuk mode mobile saat sidebar terbuka --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- Main Content --}}
    <main class="flex-1 p-4 sm:p-8">
        {{-- Tombol Hamburger untuk Mobile --}}
        <button id="menuButton" class="lg:hidden text-gray-800 text-3xl mb-4" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4 sm:mb-0">Kelola Akun Pengguna</h1>
            <!-- Menggunakan tombol yang sama untuk modal "Buat Akun Baru" -->
            <button id="openModalBtn" class="bg-teal-600 text-white px-6 py-2 rounded-full font-semibold shadow-md hover:bg-teal-700 transition duration-200 flex items-center w-full sm:w-auto justify-center">
                <i class="fas fa-plus mr-2"></i> Buat Akun Baru
            </button>
        </header>

        {{-- Pesan Status (Sukses/Gagal/Error) --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <!-- Pengecekan error untuk form STORE (Buat Akun) -->
            @php
                $isStoreError = false;
                $storeErrors = ['role', 'name', 'phone', 'password']; 
                foreach ($errors->keys() as $key) {
                    if (in_array($key, $storeErrors)) {
                        $isStoreError = true;
                        break;
                    }
                }
            @endphp
            @if($isStoreError)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">Gagal membuat akun. Mohon periksa kembali input Anda.</span>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif

        {{-- Tabel Daftar Akun --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg overflow-x-auto"> 
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4">Daftar Akun Pelatih & Atlet</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor HP (Login)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $user->name }}</td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    {{ $user->phone_number ?? '-' }} 
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $user->role == 'pelatih' ? 'bg-blue-100 text-blue-800' : ($user->role == 'admin' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    {{-- Tombol Edit - Memicu Modal Edit --}}
                                    <!-- Mengganti link href dengan class dan data attribute -->
                                    <button type="button" 
                                            class="text-blue-600 hover:text-blue-900 inline-block mr-3 btn-edit-user" 
                                            title="Edit Akun" 
                                            data-id="{{ $user->id }}"
                                            data-edit-route="{{ route('admin.users.edit', $user->id) }}"
                                            data-update-route="{{ route('admin.users.update', $user->id) }}">
                                        <i class="fas fa-edit w-5 h-5"></i>
                                    </button>
                                    
                                    {{-- Form Hapus (Ikon Sampah) - Akan dipicu oleh JS untuk menggunakan Modal --}}
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block delete-user-form" data-user-name="{{ $user->name }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" title="Hapus Akun" class="text-red-600 hover:text-red-900 delete-button">
                                            <i class="fas fa-trash-alt w-5 h-5"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada akun Pelatih atau Atlet yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
            </table>
        </div>
    </main>

    <!-- ========================================================================= -->
    <!-- Modal Buat Akun Baru (Modal Store) -->
    <!-- ========================================================================= -->
    <div id="userModal" class="modal fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center opacity-0 pointer-events-none p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform transition-transform duration-300 scale-95 modal-content">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 text-3xl">&times;</button>
            </div>
            
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <!-- Tampilkan error validasi Laravel di form ini jika ada -->
                @if ($errors->any())
                    <div id="store-errors" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 font-semibold mb-2">Pilih Peran</label>
                    <select id="role" name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                        <option value="pelatih" {{ old('role') == 'pelatih' ? 'selected' : '' }}>Pelatih</option>
                        <option value="atlet" {{ old('role') == 'atlet' ? 'selected' : '' }}>Atlet</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Pengguna</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Nomor HP (Digunakan untuk Login)</label>
                    <!-- Menggunakan nama 'phone' di sini, tapi di controller divalidasi ke 'phone_number' di DB -->
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
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
                    Simpan Akun
                </button>
            </form>
        </div>
    </div>
    
    <!-- ========================================================================= -->
    <!-- Modal Edit Pengguna (Modal Update) -->
    <!-- ========================================================================= -->
    <div id="editUserModal" class="modal fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center opacity-0 pointer-events-none p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 transform transition-transform duration-300 scale-95 modal-content">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Edit Data Pengguna</h3>
                <button type="button" id="closeEditModalBtn" class="text-gray-400 hover:text-gray-600 text-3xl">&times;</button>
            </div>
            
            <!-- Form ini akan diisi action URL-nya oleh JavaScript -->
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="edit_name" class="block text-gray-700 font-semibold mb-2">Nama Pengguna</label>
                    <input type="text" id="edit_name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="mb-4">
                    <label for="edit_phone_number" class="block text-gray-700 font-semibold mb-2">Nomor HP (Login)</label>
                    <input type="text" id="edit_phone_number" name="phone_number" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="mb-4">
                    <label for="edit_role" class="block text-gray-700 font-semibold mb-2">Peran</label>
                    <select id="edit_role" name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                        <option value="admin">Admin</option>
                        <option value="pelatih">Pelatih</option>
                        <option value="atlet">Atlet</option>
                    </select>
                </div>
                
                <hr class="my-6">
                <p class="text-gray-600 font-semibold mb-2">Ganti Kata Sandi (Opsional)</p>
                <div class="mb-4">
                    <label for="edit_password" class="block text-gray-700 font-semibold mb-2">Kata Sandi Baru</label>
                    <input type="password" id="edit_password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="mb-6">
                    <label for="edit_password_confirmation" class="block text-gray-700 font-semibold mb-2">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" id="edit_password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                </div>
                
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition duration-200 shadow-lg">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
    
    {{-- Modal Konfirmasi Hapus (Tidak Berubah) --}}
    <div id="confirmModal" class="modal fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center opacity-0 pointer-events-none p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 transform transition-transform duration-300 scale-95 modal-content">
            <h3 class="text-xl font-bold text-red-600 mb-4">Konfirmasi Hapus Akun</h3>
            <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus akun **<span id="confirmUserName" class="font-semibold"></span>**? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-end space-x-3">
                <button id="cancelDeleteBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-150">Batal</button>
                <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-150">Hapus</button>
            </div>
        </div>
    </div>

    <script>
        // Logika Sidebar Mobile (Tetap)
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


        // Logika untuk Modal Tambah Akun (Tetap)
        const storeModal = document.getElementById('userModal');
        const openStoreModalBtn = document.getElementById('openModalBtn');
        const closeStoreModalBtn = document.getElementById('closeModalBtn');

        function showStoreModal() {
            storeModal.classList.remove('opacity-0', 'pointer-events-none');
            storeModal.querySelector('.modal-content').classList.remove('scale-95');
            storeModal.querySelector('.modal-content').classList.add('scale-100');
        }

        function hideStoreModal() {
            storeModal.querySelector('.modal-content').classList.remove('scale-100');
            storeModal.querySelector('.modal-content').classList.add('scale-95');
            setTimeout(() => {
                storeModal.classList.add('opacity-0', 'pointer-events-none');
            }, 300);
        }

        openStoreModalBtn.addEventListener('click', showStoreModal);
        closeStoreModalBtn.addEventListener('click', hideStoreModal);
        
        // Menampilkan modal Store secara otomatis jika ada error validasi
        @if($errors->any())
            @if($isStoreError)
                showStoreModal();
            @endif
        @endif

        // Logika untuk Modal Edit Pengguna (AJAX)
        const editModal = document.getElementById('editUserModal');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const editUserForm = document.getElementById('editUserForm');

        // Fungsi untuk menampilkan Modal Edit
        function showEditModal() {
            editModal.classList.remove('opacity-0', 'pointer-events-none');
            editModal.querySelector('.modal-content').classList.remove('scale-95');
            editModal.querySelector('.modal-content').classList.add('scale-100');
        }

        // Fungsi untuk menyembunyikan Modal Edit
        function hideEditModal() {
            editModal.querySelector('.modal-content').classList.remove('scale-100');
            editModal.querySelector('.modal-content').classList.add('scale-95');
            setTimeout(() => {
                editModal.classList.add('opacity-0', 'pointer-events-none');
            }, 300);
        }

        closeEditModalBtn.addEventListener('click', hideEditModal);

        // Event listener untuk tombol Edit
        $('.btn-edit-user').on('click', function() {
            const userId = $(this).data('id');
            const editRoute = $(this).data('edit-route');
            const updateRoute = $(this).data('update-route');

            // 1. Atur action form modal ke route update yang benar
            $('#editUserForm').attr('action', updateRoute);

            // 2. Ambil data pengguna via AJAX (ke route users/{user}/edit)
            $.ajax({
                url: editRoute, 
                method: 'GET',
                dataType: 'json',
                success: function(user) {
                    // 3. Isi form di modal dengan data pengguna yang diterima dari JSON
                    $('#edit_name').val(user.name);
                    $('#edit_phone_number').val(user.phone_number);
                    $('#edit_role').val(user.role);
                    
                    // 4. Kosongkan field password dan konfirmasi
                    $('#edit_password').val('');
                    $('#edit_password_confirmation').val('');
                    
                    // 5. Tampilkan Modal
                    showEditModal(); 
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching user data: ", error);
                    alert("Gagal mengambil data pengguna. Silakan coba lagi. Cek konsol untuk detail.");
                }
            });
        });

        // Logika untuk Modal Konfirmasi Hapus (Tetap)
        const confirmModal = document.getElementById('confirmModal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const confirmUserName = document.getElementById('confirmUserName');
        let formToSubmit = null; 

        // Fungsi untuk menampilkan modal konfirmasi
        function showConfirmDelete(form, userName) {
            formToSubmit = form; 
            confirmUserName.textContent = userName;
            
            confirmModal.classList.remove('opacity-0', 'pointer-events-none');
            confirmModal.querySelector('.modal-content').classList.remove('scale-95');
            confirmModal.querySelector('.modal-content').classList.add('scale-100');
        }

        // Fungsi untuk menyembunyikan modal konfirmasi
        function hideConfirmModal() {
            confirmModal.querySelector('.modal-content').classList.remove('scale-100');
            confirmModal.querySelector('.modal-content').classList.add('scale-95');
            setTimeout(() => {
                confirmModal.classList.add('opacity-0', 'pointer-events-none');
                formToSubmit = null; // Reset form
            }, 300);
        }

        // Delegasi event listener untuk semua tombol hapus
        document.addEventListener('click', function(event) {
            if (event.target.closest('.delete-button')) {
                event.preventDefault(); 
                const button = event.target.closest('.delete-button');
                const form = button.closest('.delete-user-form');
                const userName = form.getAttribute('data-user-name');
                showConfirmDelete(form, userName);
            }
        });

        // Event listener untuk tombol Batal
        cancelDeleteBtn.addEventListener('click', hideConfirmModal);

        // Event listener untuk tombol Hapus (konfirmasi)
        confirmDeleteBtn.addEventListener('click', () => {
            if (formToSubmit) {
                formToSubmit.submit(); 
                hideConfirmModal();
            }
        });
    </script>

</body>
</html>
