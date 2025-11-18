<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManajemenPenggunaController extends Controller
{
    public function index()
    {
        // Ambil data untuk KPI Cards
        $totalPengguna = User::count();
        $pegawaiBPS = User::where('role', 'pegawai')->count();
        $operatorBMN = User::where('role', 'operator')->count();
        // Asumsi 'aktif' adalah default, Anda bisa tambahkan kolom status jika perlu
        $penggunaAktif = $totalPengguna;

        // Ambil daftar pengguna untuk tabel
        $users = User::orderBy('name')->get();

        return view('admin.pengguna.index', compact(
            'totalPengguna',
            'pegawaiBPS',
            'operatorBMN',
            'penggunaAktif',
            'users'
        ));
    }

    /**
     * Menampilkan form tambah pengguna baru
     */
    public function create()
    {
        return view('admin.pengguna.create');
    }

    /**
     * Menyimpan pengguna baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'jabatan' => 'required|string|max:255',
            'role' => 'required|in:operator,pegawai',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan' => $request->jabatan, // Anda perlu tambahkan kolom 'jabatan' di migrasi 'users'
            'role' => $request->role,
        ]);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pengguna
     */
    public function edit(User $pengguna)
    {
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    /**
     * Update data pengguna
     */
    public function update(Request $request, User $pengguna)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $pengguna->id,
            'jabatan' => 'required|string|max:255',
            'role' => 'required|in:operator,pegawai',
            'password' => 'nullable|string|min:8|confirmed', // Password opsional
        ]);

        $pengguna->name = $request->name;
        $pengguna->email = $request->email;
        $pengguna->jabatan = $request->jabatan;
        $pengguna->role = $request->role;

        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna
     */
    public function destroy(User $pengguna)
    {
        // Tambahkan logika agar tidak bisa hapus diri sendiri
        if (auth()->id() == $pengguna->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $pengguna->delete();
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
