@extends('layouts.app')

@section('title', 'Profil Akun')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Profil Akun']]" />
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <h2 class="text-2xl font-bold text-secondary-900 mb-6">Pengaturan Profil</h2>

    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden">
        {{-- Header Cover --}}
        <div class="h-32 bg-gradient-to-r from-primary-600 to-accent-500 relative">
            {{-- Avatar --}}
            <div class="absolute -bottom-10 left-8">
                <div class="w-24 h-24 rounded-2xl bg-white p-1.5 shadow-md">
                    <div class="w-full h-full rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-3xl font-bold border border-primary-100">
                        {{ strtoupper(substr(request()->query('role', 'S'), 0, 1)) }}
                    </div>
                </div>
            </div>
            
            {{-- Edit Cover Btn --}}
            <button class="absolute top-4 right-4 p-2 bg-black/20 hover:bg-black/40 text-white rounded-lg backdrop-blur-sm transition-colors text-xs font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                Ubah Cover
            </button>
        </div>

        <div class="pt-14 px-8 pb-8">
            <div class="mb-8 border-b border-secondary-100 pb-8">
                <h3 class="text-xl font-bold text-secondary-900 mb-1">
                    {{ ucfirst(request()->query('role', 'Staff')) }} KasaLog
                </h3>
                <p class="text-secondary-500 text-sm">Role: <span class="font-semibold text-primary-600 capitalize">{{ request()->query('role', 'Staff') }}</span></p>
            </div>

            <form class="space-y-6" data-demo-form onsubmit="event.preventDefault(); showToast('Profil berhasil diperbarui!');">
                <h4 class="font-bold text-secondary-900">Informasi Dasar</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form-input name="nama" label="Nama Lengkap / Instansi" value="{{ ucfirst(request()->query('role', 'Staff')) }} KasaLog" required />
                    <x-form-input type="email" name="email" label="Alamat Email" value="admin@kasalog.id" required />
                    <x-form-input type="text" name="telepon" label="No. Telepon / WhatsApp" value="081234567890" />
                    <div class="md:col-span-2">
                        <x-form-input type="textarea" name="alamat" label="Alamat Lengkap" rows="3" value="Gedung Utama KasaLog, Batam Center" />
                    </div>
                </div>

                <div class="pt-6 border-t border-secondary-100">
                    <h4 class="font-bold text-secondary-900 mb-6">Ubah Kata Sandi</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2 max-w-md">
                            <x-form-input type="password" name="old_password" label="Kata Sandi Saat Ini" placeholder="••••••••" />
                        </div>
                        <x-form-input type="password" name="new_password" label="Kata Sandi Baru" placeholder="••••••••" />
                        <x-form-input type="password" name="confirm_password" label="Konfirmasi Kata Sandi Baru" placeholder="••••••••" />
                    </div>
                </div>

                <div class="pt-6 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white font-medium rounded-xl hover:bg-primary-700 transition-colors shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
