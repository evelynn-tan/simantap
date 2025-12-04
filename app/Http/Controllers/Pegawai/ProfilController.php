<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function edit()
    {
        $userId = Auth::id();
        $pegawai = Pegawai::where('userID', $userId)->first();

        if (!$pegawai) {
            abort(404, 'Data pegawai tidak ditemukan');
        }

        return view('pegawai.edit-profil', compact('pegawai'));
    }

    /**
     * Memperbarui data profil atau password
     */
    public function update(Request $request)
    {
        $userId = Auth::id();
        $pegawai = Pegawai::where('userID', $userId)->first();
        $user = Auth::user();

        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        // Cek apakah ini update profil
        if ($request->has('update_profile')) {

            $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'divisi' => 'required|string|max:255',
            ]);

            // Update data pegawai
            $pegawai->update([
                'nama_lengkap' => $request->nama_lengkap,
                'jabatan' => $request->jabatan,
                'divisi' => $request->divisi,
            ]);

            return redirect()->route('pegawai.edit-profil')->with('success', 'Informasi profil berhasil diperbarui.');
        }

        // Cek apakah ini update password
        if ($request->has('update_password')) {

            $request->validate([
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', Password::min(8), 'confirmed'],
            ]);

            // Cek apakah password lama sesuai
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('pegawai.edit-profil')->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.']);
            }

            // Update password user
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('pegawai.edit-profil')->with('success', 'Password berhasil diperbarui.');
        }

        // Cek apakah ini update foto
        if ($request->has('update_foto')) {

            $request->validate([
                'foto' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            ], [
                'foto.required' => 'Pilih file foto terlebih dahulu.',
                'foto.image' => 'File harus berupa gambar.',
                'foto.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
                'foto.max' => 'Ukuran foto maksimal 2MB.',
            ]);

            // Hapus foto lama jika ada
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            // Simpan foto baru
            $fileName = 'profil_' . $pegawai->pegawaiID . '_' . time() . '.' . $request->foto->extension();
            $path = $request->foto->storeAs('profil', $fileName, 'public');

            // Update database
            $pegawai->update(['foto' => $path]);

            return redirect()->route('pegawai.edit-profil')->with('success', 'Foto profil berhasil diperbarui.');
        }

        // Cek apakah ini hapus foto
        if ($request->has('hapus_foto')) {
            
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $pegawai->update(['foto' => null]);

            return redirect()->route('pegawai.edit-profil')->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->route('pegawai.edit-profil');
    }
}
