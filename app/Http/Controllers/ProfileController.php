<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        // Ambil data user berdasarkan ID yang sedang login
        $user = UserModel::findOrFail(Auth::id());

        // Konfigurasi breadcrumb dan menu aktif
        $breadcrumb = (object) [
            'title' => 'Data Profil',
            'list' => [
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'Profil', 'url' => url('/profile')]
            ]
        ];
        $activeMenu = 'profile';

        // Tampilkan halaman profil
        return view('profile', compact('user'), [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu
        ]);
    }

    // Memperbarui profil
    public function update(Request $request, $id)
    {
        // Validasi input
        request()->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama'     => 'required|string|max:100',
            'old_password' => 'nullable|string',
            'password' => 'nullable|min:5',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        // Ambil data user berdasarkan ID
        $user = UserModel::find($id);

        // Update data username dan nama
        $user->username = $request->username;
        $user->nama = $request->nama;

        // Jika password lama diisi, cek validitasnya
        if ($request->filled('old_password')) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password); // Update password baru
            } else {
                // Jika password lama salah, kirim error
                return back()
                    ->withErrors(['old_password' => __('Please enter the correct password')])
                    ->withInput();
            }
        }

        // Jika ada file gambar yang diunggah
        if ($request->hasFile('profile_image')) {
            // Hapus gambar lama jika ada
            if ($user->profile_image && Storage::exists('public/photos/' . $user->profile_image)) {
                Storage::delete('public/photos/' . $user->profile_image);
            }

            // Simpan gambar baru
            $fileName = $request->file('profile_image')->hashName();
            $request->profile_image->storeAs('public/photos', $fileName);
            $user->profile_image = $fileName; // Simpan nama file di database
        }

        // Simpan perubahan data user ke database
        $user->save();

        // Redirect kembali ke halaman profil dengan pesan sukses
        return back()->with('status', 'Profile berhasil diperbarui');
    }
}
