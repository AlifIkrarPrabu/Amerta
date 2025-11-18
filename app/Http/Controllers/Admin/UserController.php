<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        // Anda mungkin ingin mengecualikan akun admin dari daftar kecuali Anda ingin bisa mengeditnya juga
        // $users = User::where('role', '!=', 'admin')->orderBy('name', 'asc')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat akun baru.
     * (Anda bisa menghapus metode ini jika form create sudah berada di modal index, tapi saya biarkan)
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan akun baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required|in:pelatih,atlet,admin',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:users,phone_number',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'phone_number' => $validatedData['phone'], // Pastikan nama kolom di DB adalah 'phone_number'
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dibuat!');
    }

    /**
     * Mengembalikan data pengguna dalam format JSON (untuk diisi ke dalam modal Edit).
     * Ini menggantikan pengembalian view 'admin.users.edit' Anda sebelumnya.
     */
    public function edit(User $user)
    {
        // Langsung mengembalikan model $user sebagai respons JSON
        return response()->json($user);
    }

    /**
     * Memperbarui akun pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // Pastikan phone_number unik, kecuali untuk pengguna yang sedang diedit
            'phone_number' => ['required', 'string', 'max:15', Rule::unique('users')->ignore($user->id)], 
            'role' => 'required|in:pelatih,atlet,admin', // Sesuaikan peran yang ada
            'password' => 'nullable|string|min:8|confirmed', // Jika ingin ganti password
        ]);
        
        // 2. Update data
        $user->name = $validatedData['name'];
        $user->phone_number = $validatedData['phone_number'];
        $user->role = $validatedData['role'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil diperbarui!');
    }

    /**
     * Menghapus akun pengguna dari database.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
