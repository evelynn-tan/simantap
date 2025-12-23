<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Operator;
use Illuminate\Support\Facades\Hash;

class ManajemenPenggunaController extends Controller
{
    public function index()
    {
        // Ambil data untuk KPI Cards
        $totalPengguna = User::count();
        $pegawaiBPS = User::where('role', 'pegawai')->count();
        $operatorBMN = User::where('role', 'operator')->count();

        // Ambil daftar pengguna untuk tabel
        $search = request('search');
        $query = User::with(['pegawai', 'operator']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', '%' . $search . '%')
                    ->orWhereHas('pegawai', function($sub) use ($search) {
                        $sub->where('nama_lengkap', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('operator', function($sub) use ($search) {
                        $sub->where('nama_lengkap', 'like', '%' . $search . '%');
                    });
            });
        }

        $sortBy = request('sort_by', 'email');
        $sortDir = request('sort_dir', 'asc');

        // Valid sort fields
        $validSorts = ['email', 'role', 'nama_lengkap', 'jabatan', 'nip'];
        if (!in_array($sortBy, $validSorts)) {
            $sortBy = 'email';
        }

        $users = $query->get();

        // Sort by related fields
        if (in_array($sortBy, ['nama_lengkap', 'jabatan', 'nip'])) {
            $users = $users->sort(function($a, $b) use ($sortBy, $sortDir) {
                $valA = $a->pegawai ? $a->pegawai->$sortBy : ($a->operator ? $a->operator->$sortBy : '');
                $valB = $b->pegawai ? $b->pegawai->$sortBy : ($b->operator ? $b->operator->$sortBy : '');

                if ($sortDir == 'asc') {
                    return strcmp($valA, $valB);
                } else {
                    return strcmp($valB, $valA);
                }
            })->values();
        } else {
            $users = $users->sortBy($sortBy, SORT_REGULAR, $sortDir == 'desc')->values();
        }

        return view('admin.pengguna.index', compact(
            'totalPengguna',
            'pegawaiBPS',
            'operatorBMN',
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
        $rules = [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:operator,pegawai',
        ];

        // Pegawai butuh field tambahan (nama, nip, jabatan, divisi)
        // Operator hanya butuh email/password (tanpa identitas personal)
        if ($request->role == 'pegawai') {
            $rules['name'] = 'required|string|max:255';
            $rules['jabatan'] = 'required|string|max:255';
            $rules['nip'] = 'required|string|max:255|unique:pegawais,nip';
            $rules['divisi'] = 'required|string|max:255';
        }

        $request->validate($rules);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role == 'pegawai') {
            Pegawai::create([
                'userID' => $user->userID,
                'nama_lengkap' => $request->name,
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'divisi' => $request->divisi ?? '',
            ]);
        } elseif ($request->role == 'operator') {
            // Operator hanya butuh FK ke users (tanpa identitas personal)
            Operator::create([
                'userID' => $user->userID,
            ]);
        }

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pengguna
     */
    public function edit(User $pengguna)
    {
        $pengguna->load(['pegawai', 'operator']);
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    /**
     * Update data pengguna
     */
    public function update(Request $request, User $pengguna)
    {
        $rules = [
            'email' => 'required|string|email|max:255|unique:users,email,' . $pengguna->userID . ',userID',
            'role' => 'required|in:operator,pegawai',
            'password' => 'nullable|string|min:8|confirmed', // Password opsional
        ];

        // Pegawai butuh field tambahan
        if ($request->role == 'pegawai') {
            $rules['name'] = 'required|string|max:255';
            $rules['jabatan'] = 'required|string|max:255';
            $rules['nip'] = 'required|string|max:255|unique:pegawais,nip,' . ($pengguna->pegawai ? $pengguna->pegawai->pegawaiID : 'NULL') . ',pegawaiID';
            $rules['divisi'] = 'required|string|max:255';
        }

        $request->validate($rules);

        $pengguna->email = $request->email;
        $pengguna->role = $request->role;

        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        if ($request->role == 'pegawai') {
            if ($pengguna->pegawai) {
                $pengguna->pegawai->update([
                    'nama_lengkap' => $request->name,
                    'nip' => $request->nip,
                    'jabatan' => $request->jabatan,
                    'divisi' => $request->divisi ?? $pengguna->pegawai->divisi,
                ]);
            } else {
                Pegawai::create([
                    'userID' => $pengguna->userID,
                    'nama_lengkap' => $request->name,
                    'nip' => $request->nip,
                    'jabatan' => $request->jabatan,
                    'divisi' => $request->divisi ?? '',
                ]);
                // If was operator, delete operator
                if ($pengguna->operator) {
                    $pengguna->operator->delete();
                }
            }
        } elseif ($request->role == 'operator') {
            // Operator tidak punya field personal, hanya userID
            if (!$pengguna->operator) {
                Operator::create([
                    'userID' => $pengguna->userID,
                ]);
            }
            // Jika sebelumnya pegawai, hapus data pegawai
            if ($pengguna->pegawai) {
                $pengguna->pegawai->delete();
            }
        }

        return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna
     */
    public function destroy(User $pengguna)
    {
        // Tambahkan logika agar tidak bisa hapus diri sendiri
        if (auth()->id() == $pengguna->userID) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $pengguna->delete();
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
