<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="KasaLog - Solusi Distribusi Produk UMKM Antarpulau Terpercaya">
    <title>KasaLog - Solusi Distribusi Produk UMKM Antarpulau</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .landing-nav {
            font-family: 'Inter', sans-serif;
        }
        .hero-overlay {
            background: linear-gradient(to right, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.6) 40%, rgba(15, 23, 42, 0.3) 70%, transparent 100%);
        }
        .search-floating {
            box-shadow: 0 8px 40px rgba(0,0,0,0.12);
        }
        .bento-image-overlay {
            background: linear-gradient(to top, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.3) 40%, transparent 70%);
        }
        .dark-card-glow {
            background: radial-gradient(ellipse at top right, rgba(6, 182, 212, 0.15), transparent 60%);
        }
        .stat-divider > div:not(:first-child) {
            border-left: 1px solid rgba(255,255,255,0.1);
        }
        .cta-card-pattern {
            background-image: radial-gradient(circle at 20% 80%, rgba(6,182,212,0.08) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(59,130,246,0.08) 0%, transparent 50%);
        }
        /* Scroll animations */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .fade-up-delay-1 { transition-delay: 0.1s; }
        .fade-up-delay-2 { transition-delay: 0.2s; }
        .fade-up-delay-3 { transition-delay: 0.3s; }
        .fade-up-delay-4 { transition-delay: 0.4s; }
    </style>
</head>
<body class="font-sans text-secondary-700 antialiased bg-white">

    {{-- ============================================================ --}}
    {{-- NAVBAR --}}
    {{-- ============================================================ --}}
    <nav id="landing-nav" class="landing-nav fixed top-0 inset-x-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-md shadow-sm border-b border-secondary-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <a href="/" class="text-2xl font-extrabold text-secondary-900 tracking-tight">
                    Kasa<span class="text-primary-600">Log</span>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center space-x-10">
                    <a href="#" class="text-secondary-900 font-semibold text-sm border-b-2 border-primary-600 pb-0.5">Beranda</a>
                    <a href="#keunggulan" class="text-secondary-500 hover:text-secondary-900 font-medium text-sm transition-colors">Tentang Kami</a>
                </div>

                {{-- CTA Button --}}
                <div class="hidden md:block">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-5 py-2 text-sm font-semibold rounded-lg text-white bg-secondary-900 hover:bg-secondary-800 transition-colors shadow-sm">
                        Masuk/Daftar
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 text-secondary-600 hover:text-secondary-900 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-secondary-100 mt-2 pt-4 space-y-3">
                <a href="#" class="block text-secondary-900 font-semibold text-sm py-2">Beranda</a>
                <a href="#keunggulan" class="block text-secondary-500 hover:text-secondary-900 font-medium text-sm py-2">Tentang Kami</a>
             <a href="{{ route('login') }}" class="block w-full text-center px-5 py-2.5 text-sm font-semibold rounded-lg text-white bg-secondary-900 hover:bg-secondary-800 transition-colors mt-2">Masuk/Daftar</a>
            </div>
        </div>
    </nav>

    {{-- ============================================================ --}}
    {{-- HERO SECTION --}}
    {{-- ============================================================ --}}
    <section class="relative min-h-[92vh] flex items-center pt-16">
        {{-- Background Image --}}
        <div class="absolute inset-0">
            <img src="/img/hero-bg.png" alt="Kapal Kargo" class="w-full h-full object-cover">
            <div class="hero-overlay absolute inset-0"></div>
        </div>

        {{-- Hero Content --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-xl lg:max-w-2xl pb-24">
                <h1 class="text-4xl sm:text-5xl lg:text-[3.4rem] font-extrabold text-white leading-[1.15] tracking-tight mb-6">
                    Solusi Distribusi Produk UMKM Antarpulau Terpercaya.
                </h1>
                <p class="text-base lg:text-lg text-gray-300 mb-10 leading-relaxed max-w-lg font-light">
                    Hubungkan produk UMKM Anda ke seluruh kepri dengan sistem manajemen pesanan, logistik, dan pelacakan pengiriman.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('login') }}" class="px-7 py-3 text-sm font-bold rounded-xl text-white bg-warning-500 hover:bg-warning-600 shadow-lg transition-all">
                        Bergabung Sekarang
                    </a>
                   
                </div>
            </div>
        </div>

    </section>

    {{-- ============================================================ --}}
    {{-- KEUNGGULAN KASALOG - BENTO GRID --}}
    {{-- ============================================================ --}}
    <section id="keunggulan" class="pt-28 pb-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Title --}}
            <div class="text-center mb-14 fade-up">
                <h2 class="text-2xl sm:text-3xl font-bold text-secondary-900 inline-block relative pb-4">
                    Keunggulan KasaLog
                    <span class="absolute bottom-0 left-1/4 right-1/4 h-1 bg-warning-500 rounded-full"></span>
                </h2>
            </div>

            {{-- Bento Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:auto-rows-[220px]">

                {{-- 1. Manajemen Terpusat (top-left, 1 row) --}}
                <div class="bg-secondary-50 rounded-2xl p-7 flex flex-col justify-center border border-secondary-100 hover:shadow-lg transition-shadow fade-up">
                    <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center mb-4 shadow-sm border border-secondary-100">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-secondary-900 mb-1.5">Manajemen Terpusat</h3>
                    <p class="text-secondary-500 text-sm leading-relaxed">Satu platform intuitif untuk mengelola Order, Rute, hingga Konfirmasi Pengiriman tanpa ribet.</p>
                </div>

                {{-- 2. Center Image (center column, spans 2 rows) --}}
                <div class="md:row-span-2 relative rounded-2xl overflow-hidden group border border-secondary-100 shadow-md fade-up fade-up-delay-1">
                    <img src="/img/tablet-dashboard.png" alt="Dashboard KasaLog" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="bento-image-overlay absolute inset-0"></div>
                </div>

                {{-- 3. Pelacakan Akurat (right column, spans 2 rows) --}}
                <div class="md:row-span-2 bg-secondary-900 rounded-2xl p-8 flex flex-col justify-end text-white shadow-lg relative overflow-hidden fade-up fade-up-delay-2">
                    <div class="dark-card-glow absolute inset-0"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center mb-5 border border-white/15">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Pelacakan Akurat</h3>
                        <p class="text-gray-300 text-sm leading-relaxed">Update status pengiriman secara real-time langsung dari kapal dan armada logistik kami. Ketahui posisi pasti barang Anda.</p>
                    </div>
                </div>

                {{-- 4. Rute & Pelabuhan (bottom-left, spans 2 rows starting from row 2) --}}
                <div class="md:row-span-2 bg-accent-50 rounded-2xl p-7 flex flex-col justify-center border border-accent-100 hover:shadow-lg transition-shadow fade-up fade-up-delay-1">
                    <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center mb-5 shadow-sm border border-accent-100">
                        <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-secondary-900 mb-2">Rute & Pelabuhan</h3>
                    <p class="text-secondary-600 text-sm leading-relaxed">Terhubung langsung dengan data manifest pelabuhan resmi di seluruh Kepulauan Riau dan sekitarnya.</p>
                </div>

                {{-- 5. Ekosistem UMKM (bottom, spans 2 columns) --}}
                <div class="md:col-span-2 bg-secondary-50 rounded-2xl p-7 flex flex-col sm:flex-row items-center gap-6 border border-secondary-100 hover:shadow-lg transition-shadow fade-up fade-up-delay-2">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-secondary-900 mb-1.5">Ekosistem UMKM</h3>
                        <p class="text-secondary-500 text-sm leading-relaxed">Pemberdayaan pengusaha lokal dengan akses logistik premium yang terjangkau.</p>
                    </div>
                    <div class="flex -space-x-2.5 shrink-0">
                        <div class="w-10 h-10 rounded-full bg-white border-2 border-secondary-50 flex items-center justify-center shadow-sm text-secondary-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white border-2 border-secondary-50 flex items-center justify-center shadow-sm text-warning-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white border-2 border-secondary-50 flex items-center justify-center shadow-sm text-success-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CARA KERJA KASALOG --}}
    {{-- ============================================================ --}}
    <section class="py-20 bg-surface border-y border-secondary-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Title --}}
            <div class="text-center mb-14 fade-up">
                <h2 class="text-2xl sm:text-3xl font-bold text-secondary-900 mb-2">Cara Kerja KasaLog</h2>
                <p class="text-secondary-500 text-sm">Proses pengiriman yang transparan dan terukur</p>
            </div>

            {{-- Steps --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 md:gap-8 relative">
                {{-- Connecting Line (desktop) --}}
                <div class="hidden md:block absolute top-10 left-[12%] right-[12%] h-[2px] bg-secondary-200 z-0"></div>

                {{-- Step 1: Pemesanan --}}
                <div class="relative z-10 flex flex-col items-center text-center fade-up">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-md border border-secondary-100 mb-5">
                        <div class="w-14 h-14 bg-info-50 text-info-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                    </div>
                    <h4 class="text-base font-bold text-secondary-900 mb-1.5">Pemesanan</h4>
                    <p class="text-xs text-secondary-500 leading-relaxed max-w-[200px]">Input data pengiriman dan pilih rute terbaik untuk produk Anda.</p>
                </div>

                {{-- Step 2: Pemrosesan --}}
                <div class="relative z-10 flex flex-col items-center text-center fade-up fade-up-delay-1">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-md border border-secondary-100 mb-5">
                        <div class="w-14 h-14 bg-primary-50 text-primary-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                    </div>
                    <h4 class="text-base font-bold text-secondary-900 mb-1.5">Pemrosesan</h4>
                    <p class="text-xs text-secondary-500 leading-relaxed max-w-[200px]">Tim operator memverifikasi dan menyiapkan kargo di gudang pelabuhan.</p>
                </div>

                {{-- Step 3: Pengiriman --}}
                <div class="relative z-10 flex flex-col items-center text-center fade-up fade-up-delay-2">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-md border border-secondary-100 mb-5">
                        <div class="w-14 h-14 bg-warning-50 text-warning-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        </div>
                    </div>
                    <h4 class="text-base font-bold text-secondary-900 mb-1.5">Pengiriman</h4>
                    <p class="text-xs text-secondary-500 leading-relaxed max-w-[200px]">Kargo berlayar menuju pelabuhan tujuan dengan pantauan real-time.</p>
                </div>

                {{-- Step 4: Penerimaan --}}
                <div class="relative z-10 flex flex-col items-center text-center fade-up fade-up-delay-3">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-md border border-secondary-100 mb-5">
                        <div class="w-14 h-14 bg-success-50 text-success-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>
                    <h4 class="text-base font-bold text-secondary-900 mb-1.5">Penerimaan</h4>
                    <p class="text-xs text-secondary-500 leading-relaxed max-w-[200px]">Konfirmasi penerimaan barang dan penyelesaian administrasi.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- SIAPA YANG KAMI LAYANI --}}
    {{-- ============================================================ --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Title --}}
            <div class="text-center mb-14 fade-up">
                <h2 class="text-2xl sm:text-3xl font-bold text-secondary-900">Siapa Yang Kami Layani?</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
                {{-- Card: UMKM (Supplier) --}}
                <div class="bg-white rounded-2xl shadow-lg border border-secondary-100 border-t-4 border-t-primary-500 p-7 hover:-translate-y-1 transition-transform duration-300 fade-up">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-lg font-bold text-secondary-900">UMKM (Supplier)</h3>
                        <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    </div>
                    <ul class="space-y-3.5">
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-secondary-600 text-sm">Akses ke pasar antarpulau lebih luas</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-secondary-600 text-sm">Biaya pengiriman yang kompetitif</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-secondary-600 text-sm">Dashboard manajemen stok digital</span>
                        </li>
                    </ul>
                </div>

                {{-- Card: Konsumen --}}
                <div class="bg-white rounded-2xl shadow-lg border border-secondary-100 border-t-4 border-t-info-500 p-7 hover:-translate-y-1 transition-transform duration-300 fade-up fade-up-delay-1">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-lg font-bold text-secondary-900">Konsumen</h3>
                        <div class="w-10 h-10 rounded-full bg-info-50 text-info-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                    <ul class="space-y-3.5">
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-secondary-600 text-sm">Tracking status barang yang presisi</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-secondary-600 text-sm">Notifikasi pengiriman otomatis</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-secondary-600 text-sm">Produk sampai lebih cepat & aman</span>
                        </li>
                    </ul>
                </div>

                {{-- Card: Operator Logistik --}}
                <div class="bg-white rounded-2xl shadow-lg border border-secondary-100 border-t-4 border-t-success-500 p-7 hover:-translate-y-1 transition-transform duration-300 fade-up fade-up-delay-2">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-lg font-bold text-secondary-900">Operator Logistik</h3>
                        <div class="w-10 h-10 rounded-full bg-success-50 text-success-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                    </div>
                    <ul class="space-y-3.5">
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-secondary-600 text-sm">Optimalisasi rute dan muatan kapal</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-secondary-600 text-sm">Digitalisasi manifest keberangkatan</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-secondary-600 text-sm">Laporan performa armada bulanan</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- STATS SECTION --}}
    {{-- ============================================================ --}}
    <section class="py-14 bg-secondary-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="stat-divider grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="px-4 fade-up">
                    <p class="text-4xl md:text-5xl font-extrabold text-accent-300 mb-1.5" data-count="50">0+</p>
                    <p class="text-secondary-400 text-xs uppercase tracking-widest font-medium">Pelabuhan Terhubung</p>
                </div>
                <div class="px-4 fade-up fade-up-delay-1">
                    <p class="text-4xl md:text-5xl font-extrabold text-accent-300 mb-1.5" data-count="200">0+</p>
                    <p class="text-secondary-400 text-xs uppercase tracking-widest font-medium">Rute Aktif</p>
                </div>
                <div class="px-4 fade-up fade-up-delay-2">
                    <p class="text-4xl md:text-5xl font-extrabold text-accent-300 mb-1.5" data-count="1000">0+</p>
                    <p class="text-secondary-400 text-xs uppercase tracking-widest font-medium">UMKM Terdaftar</p>
                </div>
                <div class="px-4 fade-up fade-up-delay-3">
                    <p class="text-4xl md:text-5xl font-extrabold text-accent-300 mb-1.5" data-count="10000" data-suffix="Rb">0Rb+</p>
                    <p class="text-secondary-400 text-xs uppercase tracking-widest font-medium">Pengiriman Sukses</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- BOTTOM CTA --}}
    {{-- ============================================================ --}}
    <section class="py-20 bg-surface">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-secondary-900 rounded-[2.5rem] px-8 py-16 md:px-16 md:py-20 text-center relative overflow-hidden shadow-2xl cta-card-pattern fade-up">
                <div class="relative z-10">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-5 leading-tight">Siap Memperluas Jangkauan<br class="hidden sm:block"> Bisnis Anda?</h2>
                    <p class="text-secondary-400 max-w-xl mx-auto mb-9 text-sm leading-relaxed">
                        Bergabunglah dengan ekosistem KasaLog dan nikmati kemudahan distribusi logistik antarpulau yang modern dan aman.
                    </p>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold rounded-xl text-white bg-warning-500 hover:bg-warning-600 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                        Daftar sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================================ --}}
    <footer class="bg-[#0b1120] text-secondary-400 pt-14 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 mb-10">
                {{-- Col 1: Logo --}}
                <div>
                    <a href="/" class="text-xl font-extrabold text-white tracking-tight inline-block mb-3">Kasa<span class="text-primary-500">Log</span></a>
                    <p class="text-xs text-secondary-500 leading-relaxed mb-5">Logistik Terpercaya Kepulauan Riau.</p>
                    <div class="flex items-center gap-4 text-xs">
                        <a href="#" class="text-secondary-500 hover:text-white transition-colors">Facebook</a>
                        <a href="#" class="text-secondary-500 hover:text-white transition-colors">Instagram</a>
                        <a href="#" class="text-secondary-500 hover:text-white transition-colors">LinkedIn</a>
                    </div>
                </div>

                {{-- Col 2: Hubungi Kami --}}
                <div>
                    <h4 class="text-white font-semibold mb-5 text-xs uppercase tracking-widest">Hubungi Kami</h4>
                    <ul class="space-y-3 text-xs text-secondary-500">
                        <li>Batam Center, Batam,<br>Kepulauan Riau</li>
                        <li>admin@kasalog.id</li>
                        <li>+62 812-3456-7890</li>
                    </ul>
                </div>

                {{-- Col 3: Portal Pengguna --}}
                <div>
                    <h4 class="text-white font-semibold mb-5 text-xs uppercase tracking-widest">Portal Pengguna</h4>
                    <ul class="space-y-3 text-xs">
                        <li><a href="#" class="text-secondary-500 hover:text-primary-400 transition-colors">Portal Supplier</a></li>
                        <li><a href="#" class="text-secondary-500 hover:text-primary-400 transition-colors">Portal Operator</a></li>
                        <li><a href="#" class="text-secondary-500 hover:text-primary-400 transition-colors">Portal Konsumen</a></li>
                    </ul>
                </div>

                {{-- Col 4: Lainnya --}}
                <div>
                    <h4 class="text-white font-semibold mb-5 text-xs uppercase tracking-widest">Lainnya</h4>
                    <ul class="space-y-3 text-xs">
                        <li><a href="#" class="text-secondary-500 hover:text-primary-400 transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-secondary-500 hover:text-primary-400 transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-secondary-500 hover:text-primary-400 transition-colors">Bantuan</a></li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="border-t border-secondary-800 pt-6 text-xs text-secondary-600 text-center md:text-left">
                <p>&copy; 2026 KasaLog. Logistik Terpercaya Kepulauan Riau.</p>
            </div>
        </div>
    </footer>

    {{-- ============================================================ --}}
    {{-- NATIVE JS --}}
    {{-- ============================================================ --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // ---- Mobile Menu Toggle ----
        var mobileBtn = document.getElementById('mobile-menu-btn');
        var mobileMenu = document.getElementById('mobile-menu');
        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // ---- Smooth Scroll for anchor links ----
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                var target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    // Close mobile menu if open
                    if (mobileMenu) mobileMenu.classList.add('hidden');
                }
            });
        });

        // ---- Scroll Fade-Up Animations ----
        var fadeEls = document.querySelectorAll('.fade-up');
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.15 });

        fadeEls.forEach(function(el) { observer.observe(el); });

        // ---- Counter Animation for Stats ----
        var counters = document.querySelectorAll('[data-count]');
        var counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting && !entry.target.dataset.counted) {
                    entry.target.dataset.counted = 'true';
                    var target = parseInt(entry.target.dataset.count);
                    var suffix = entry.target.dataset.suffix || '';
                    var duration = 2000;
                    var startTime = null;

                    function animate(currentTime) {
                        if (!startTime) startTime = currentTime;
                        var progress = Math.min((currentTime - startTime) / duration, 1);
                        // Ease out cubic
                        var eased = 1 - Math.pow(1 - progress, 3);
                        var current = Math.floor(eased * target);

                        if (suffix === 'Rb') {
                            var display = current >= 1000 ? Math.floor(current / 1000) : current;
                            if (current >= 1000) {
                                entry.target.textContent = Math.floor(current / 1000) + 'Rb+';
                            } else {
                                entry.target.textContent = current + '+';
                            }
                        } else {
                            entry.target.textContent = current + '+';
                        }

                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        }
                    }
                    requestAnimationFrame(animate);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(function(el) { counterObserver.observe(el); });
    });
    </script>

</body>
</html>
