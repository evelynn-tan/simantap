<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('pegawai.profil.edit', compact('user'));
    }

    /**
     * Memperbarui data profil atau password
     * Sesuai mockup: ...09_31_39.jpg & ...09_31_52.jpg
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Cek apakah ini update profil
        if ($request->has('update_profile')) {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'nip' => 'nullable|string|max:20', // Sesuaikan jika NIP wajib
                'jabatan' => 'nullable|string|max:255',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;

            // Simpan NIP/Jabatan. 
            // NOTE: Anda perlu menambahkan kolom 'nip' dan 'jabatan' ke migrasi 'users'
            // $user->nip = $request->nip; 
            // $user->jabatan = $request->jabatan;

            $user->save();

            return redirect()->route('pegawai.profil.edit')->with('success_profile', 'Informasi profil berhasil diperbarui.');
        }

        // Cek apakah ini update password
        if ($request->has('update_password')) {

            $request->validate([
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', Password::min(8), 'confirmed'],
            ]);

            // Cek apakah password lama sesuai
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('pegawai.profil.edit')->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.'])->with('tab', 'password');
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('pegawai.profil.edit')->with('success_password', 'Password berhasil diperbarui.')->with('tab', 'password');
        }

        return redirect()->route('pegawai.profil.edit');
    }
}
