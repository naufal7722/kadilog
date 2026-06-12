@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex">
    {{-- Left Side - Branding --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-hero relative overflow-hidden">
        {{-- Decorative Elements --}}
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-accent-500/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-primary-400/10 rounded-full blur-2xl"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 flex flex-col justify-between w-full p-12">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 flex items-center justify-center">
                    <img src="{{ asset('img/logo_kasalog.png') }}" alt="Logo KasaLog" class="w-full h-full object-contain">
                </div>
                <span class="text-2xl font-bold text-white tracking-tight">KasaLog</span>
            </div>

            {{-- Main Illustration Text --}}
            <div class="space-y-6">
                <div>
                    <h2 class="text-4xl font-bold text-white leading-tight mb-4">
                        Distribusi UMKM<br>
                        <span class="text-accent-300">Antarpulau</span> Lebih Mudah
                    </h2>
                    <p class="text-lg text-primary-200 max-w-md leading-relaxed">
                        Kelola pengiriman barang dari supplier ke konsumen di seluruh kepulauan Indonesia dengan sistem tracking real-time.
                    </p>
                </div>

                {{-- Feature Pills --}}
                <div class="flex flex-wrap gap-3">
                    <div class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur rounded-xl border border-white/10 text-white/80 text-sm">
                        <svg class="w-4 h-4 text-accent-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Multi-Operator
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur rounded-xl border border-white/10 text-white/80 text-sm">
                        <svg class="w-4 h-4 text-accent-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Tracking Real-time
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur rounded-xl border border-white/10 text-white/80 text-sm">
                        <svg class="w-4 h-4 text-accent-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        Manajemen Rute
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-6">
                <div>
                    <p class="text-3xl font-bold text-white">150+</p>
                    <p class="text-sm text-primary-300">Supplier Aktif</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-white">34</p>
                    <p class="text-sm text-primary-300">Pelabuhan</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-white">1.2K</p>
                    <p class="text-sm text-primary-300">Pengiriman/Bulan</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Side - Login Form --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 bg-white">
        <div class="w-full max-w-md space-y-8">
            {{-- Mobile Logo --}}
            <div class="lg:hidden flex items-center justify-center gap-3 mb-8">
                <div class="w-11 h-11 flex items-center justify-center">
                    <img src="{{ asset('img/logo_kasalog.png') }}" alt="Logo KasaLog" class="w-full h-full object-contain">
                </div>
                <span class="text-2xl font-bold text-secondary-900 tracking-tight">KasaLog</span>
            </div>

            {{-- Header --}}
            <div>
                <h1 class="text-2xl font-bold text-secondary-900 mb-1">Masuk ke Akun Anda</h1>
                <p class="text-secondary-500">Silakan masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            {{-- Login Form --}}
            <form class="space-y-5" action="{{ route('login') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-secondary-700">Email</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-secondary-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full pl-11 pr-4 py-2.5 bg-white border @error('email') border-danger-500 @else border-secondary-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors outline-none" placeholder="nama@email.com">
                    </div>
                </div>

                {{-- Password --}}
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-secondary-700">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-secondary-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" name="password" required class="w-full pl-11 pr-4 py-2.5 bg-white border @error('email') border-danger-500 @else border-secondary-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors outline-none" placeholder="••••••••">
                    </div>
                    @error('email')
                        <p class="text-sm text-danger-500 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" checked class="w-4 h-4 rounded border-secondary-300 text-primary-600 focus:ring-primary-500/20">
                        <span class="text-sm text-secondary-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">Lupa kata sandi?</a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl font-semibold text-sm hover:from-primary-700 hover:to-primary-800 focus:ring-4 focus:ring-primary-500/20 transition-all shadow-lg shadow-primary-500/25 active:scale-[0.98]">
                    Masuk
                </button>
            </form>

            {{-- Footer --}}
            <p class="text-center text-xs text-secondary-400">
                &copy; 2024 KasaLog. Sistem Informasi Distribusi UMKM Antarpulau.
            </p>
        </div>
    </div>
</div>

</div>
@endsection
