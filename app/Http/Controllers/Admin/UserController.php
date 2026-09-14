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
     * Menampilkan daftar semua pengguna dengan fitur pencarian & pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('phone_number', 'like', "%{$search}%");
        })
        ->orderBy('name', 'asc')
        ->paginate(5)
        ->withQueryString(); // Memastikan parameter search tetap ada saat klik halaman lain

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Menampilkan form untuk membuat akun baru.
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
            'phone_number' => $validatedData['phone'],
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dibuat!');
    }

    /**
     * Mengembalikan data pengguna dalam format JSON (untuk diisi ke dalam modal Edit).
     */
    public function edit(User $user)
    {
        return response()->json($user);
    }

    /**
     * Memperbarui akun pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => ['required', 'string', 'max:15', Rule::unique('users')->ignore($user->id)], 
            'role' => 'required|in:pelatih,atlet,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
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