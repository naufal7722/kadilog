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
                        {{ strtoupper(substr($user->name, 0, 1)) }}
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
                    {{ $user->name }}
                </h3>
                <p class="text-secondary-500 text-sm">Role: <span class="font-semibold text-primary-600 capitalize">{{ $role }}</span></p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-success-50 border-l-4 border-success-500 text-success-700 rounded-lg flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="flex-1 text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-danger-50 border border-danger-200 text-danger-700 rounded-xl">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form-input name="name" label="Username" value="{{ old('name', $user->name) }}" required />
                    <x-form-input type="email" name="email" label="Alamat Email" value="{{ old('email', $user->email) }}" required />

                @if($role === 'supplier' && $user->supplier)
                    <x-form-input name="nama_umkm" label="Nama UMKM" value="{{ old('nama_umkm', $user->supplier->nama_umkm) }}" required />
                    <x-form-input name="nama_pic" label="Nama PIC" value="{{ old('nama_pic', $user->supplier->nama_pic) }}" required />
                    <x-form-input name="no_hp_pic" label="No. HP PIC" value="{{ old('no_hp_pic', $user->supplier->no_hp_pic) }}" required />
                    <div class="md:col-span-2">
                        <x-form-input type="textarea" name="alamat" label="Alamat Lengkap" rows="3" value="{{ old('alamat', $user->supplier->alamat) }}" required />
                    </div>
                @elseif($role === 'konsumen' && $user->konsumen)
                    <x-form-input name="nama_konsumen" label="Nama Konsumen" value="{{ old('nama_konsumen', $user->konsumen->nama_konsumen) }}" required />
                    <x-form-input name="nama_pic_konsumen" label="Nama PIC Konsumen" value="{{ old('nama_pic_konsumen', $user->konsumen->nama_pic_konsumen) }}" required />
                @elseif($role === 'operator' && $user->operator)
                    <x-form-input name="nama_operator" label="Nama Operator" value="{{ old('nama_operator', $user->operator->nama_operator) }}" required />
                    <x-form-input name="no_hp" label="No. HP" value="{{ old('no_hp', $user->operator->no_hp) }}" required />
                @endif
                </div>

                <div class="pt-6 border-t border-secondary-100">
                    <h4 class="font-bold text-secondary-900 mb-6">Ubah Kata Sandi (Opsional)</h4>
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
