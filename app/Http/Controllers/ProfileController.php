<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user()->load(['supplier', 'konsumen', 'operator']);
        return view('profile.index', [
            'role' => $user->role ?? 'staff',
            'pageTitle' => 'Profil Saya',
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'old_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'required_with:old_password'],
            'confirm_password' => ['nullable', 'same:new_password']
        ];

        if ($role === 'supplier') {
            $rules['nama_umkm'] = ['required', 'string', 'max:255'];
            $rules['alamat'] = ['required', 'string'];
            $rules['nama_pic'] = ['required', 'string', 'max:255'];
            $rules['no_hp_pic'] = ['required', 'string', 'max:255'];
        } elseif ($role === 'konsumen') {
            $rules['nama_konsumen'] = ['required', 'string', 'max:255'];
            $rules['nama_pic_konsumen'] = ['required', 'string', 'max:255'];
        } elseif ($role === 'operator') {
            $rules['nama_operator'] = ['required', 'string', 'max:255'];
            $rules['no_hp'] = ['required', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['old_password'])) {
            if (!Hash::check($validated['old_password'], $user->password)) {
                return back()->withErrors(['old_password' => 'Kata sandi saat ini tidak sesuai.']);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        // Update related model
        if ($role === 'supplier' && $user->supplier) {
            $user->supplier->update([
                'nama_umkm' => $validated['nama_umkm'],
                'alamat' => $validated['alamat'],
                'nama_pic' => $validated['nama_pic'],
                'no_hp_pic' => $validated['no_hp_pic'],
            ]);
        } elseif ($role === 'konsumen' && $user->konsumen) {
            $user->konsumen->update([
                'nama_konsumen' => $validated['nama_konsumen'],
                'nama_pic_konsumen' => $validated['nama_pic_konsumen'],
            ]);
        } elseif ($role === 'operator' && $user->operator) {
            $user->operator->update([
                'nama_operator' => $validated['nama_operator'],
                'no_hp' => $validated['no_hp'],
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
