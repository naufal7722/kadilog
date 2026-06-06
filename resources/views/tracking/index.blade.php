@extends('layouts.app')

@section('title', 'Tracking Delivery')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Tracking', 'href' => '/tracking']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Tracking Delivery</h2>
            <p class="text-secondary-500 mt-1">Pantau posisi pengiriman barang Anda secara real-time.</p>
        </div>
        
        {{-- Search Resi Khusus di Halaman Tracking --}}
        <div class="relative w-full sm:w-80">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-primary-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" class="w-full pl-10 pr-24 py-3 bg-white border-2 border-primary-100 rounded-xl text-sm focus:border-primary-500 outline-none shadow-sm transition-colors placeholder:text-secondary-400" placeholder="Masukkan Nomor Resi / Order...">
            <button class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-primary-600 text-white rounded-lg text-xs font-bold hover:bg-primary-700 transition-colors">
                Lacak
            </button>
        </div>
    </div>

    {{-- Daftar Pengiriman Aktif (Grid View) --}}
    <h3 class="text-lg font-bold text-secondary-900 mt-8">Pengiriman Aktif Saat Ini</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        
        {{-- Card Tracking 1 --}}
        <div class="bg-white rounded-2xl border border-secondary-200 shadow-sm overflow-hidden hover:border-primary-300 transition-all flex flex-col group">
            <div class="p-5 border-b border-secondary-100 flex justify-between items-start bg-secondary-50/50">
                <div>
                    <span class="inline-block px-2.5 py-1 bg-white border border-secondary-200 rounded-lg text-xs font-bold text-secondary-800 mb-2 shadow-sm">
                        #ORD-2024-101
                    </span>
                    <h4 class="font-bold text-secondary-900">Sepatu Kulit Lokal</h4>
                </div>
                <x-badge-status status="Dalam Perjalanan ke Pelabuhan" />
            </div>
            
            <div class="p-5 flex-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-1">
                        <p class="text-xs text-secondary-500 mb-0.5">Asal</p>
                        <p class="font-semibold text-secondary-900 text-sm">Batam</p>
                    </div>
                    <div class="px-3">
                        <svg class="w-5 h-5 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                    <div class="flex-1 text-right">
                        <p class="text-xs text-secondary-500 mb-0.5">Tujuan Akhir</p>
                        <p class="font-semibold text-secondary-900 text-sm">Natuna</p>
                    </div>
                </div>

                {{-- Mini Progress Bar --}}
                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-medium">
                        <span class="text-primary-600">Progress</span>
                        <span class="text-secondary-600">35%</span>
                    </div>
                    <div class="w-full bg-secondary-100 rounded-full h-2">
                        <div class="bg-primary-500 h-2 rounded-full" style="width: 35%"></div>
                    </div>
                    <p class="text-[11px] text-secondary-500 mt-1">Posisi terakhir: Tiba di Pelabuhan Batu Ampar</p>
                </div>
            </div>

            <div class="p-4 bg-secondary-50/50 border-t border-secondary-100">
                <a href="/tracking/101?role={{ request()->query('role', 'staff') }}" class="flex justify-center items-center w-full py-2 bg-white border border-secondary-200 rounded-lg text-sm font-semibold text-primary-600 hover:bg-primary-50 hover:border-primary-200 transition-colors">
                    Lihat Detail Tracking
                </a>
            </div>
        </div>

        {{-- Card Tracking 2 --}}
        <div class="bg-white rounded-2xl border border-secondary-200 shadow-sm overflow-hidden hover:border-primary-300 transition-all flex flex-col group">
            <div class="p-5 border-b border-secondary-100 flex justify-between items-start bg-secondary-50/50">
                <div>
                    <span class="inline-block px-2.5 py-1 bg-white border border-secondary-200 rounded-lg text-xs font-bold text-secondary-800 mb-2 shadow-sm">
                        #ORD-2024-105
                    </span>
                    <h4 class="font-bold text-secondary-900">Barang Elektronik</h4>
                </div>
                <x-badge-status status="Menunggu Pickup" />
            </div>
            
            <div class="p-5 flex-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-1">
                        <p class="text-xs text-secondary-500 mb-0.5">Asal</p>
                        <p class="font-semibold text-secondary-900 text-sm">Batam</p>
                    </div>
                    <div class="px-3">
                        <svg class="w-5 h-5 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                    <div class="flex-1 text-right">
                        <p class="text-xs text-secondary-500 mb-0.5">Tujuan Akhir</p>
                        <p class="font-semibold text-secondary-900 text-sm">Karimun</p>
                    </div>
                </div>

                {{-- Mini Progress Bar --}}
                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-medium">
                        <span class="text-warning-600">Progress</span>
                        <span class="text-secondary-600">5%</span>
                    </div>
                    <div class="w-full bg-secondary-100 rounded-full h-2">
                        <div class="bg-warning-500 h-2 rounded-full animate-pulse-soft" style="width: 5%"></div>
                    </div>
                    <p class="text-[11px] text-secondary-500 mt-1">Posisi terakhir: Menunggu pickup di Gudang Supplier</p>
                </div>
            </div>

            <div class="p-4 bg-secondary-50/50 border-t border-secondary-100">
                <a href="/tracking/105?role={{ request()->query('role', 'staff') }}" class="flex justify-center items-center w-full py-2 bg-white border border-secondary-200 rounded-lg text-sm font-semibold text-primary-600 hover:bg-primary-50 hover:border-primary-200 transition-colors">
                    Lihat Detail Tracking
                </a>
            </div>
        </div>
    </div>
    
    {{-- Riwayat Selesai --}}
    <h3 class="text-lg font-bold text-secondary-900 mt-8 mb-4">Riwayat Pengiriman Selesai</h3>
    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">No. Order / Waktu Selesai</th>
                        <th class="px-6 py-3 font-medium">Barang</th>
                        <th class="px-6 py-3 font-medium">Rute</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    <tr class="table-row-hover">
                        <td class="px-6 py-4">
                            <span class="font-bold text-secondary-900">#ORD-2024-098</span>
                            <span class="block text-xs text-secondary-500 mt-1">22 Okt 2024, 14:30</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-secondary-900">Pakaian Jadi</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">Batam → Bintan</td>
                        <td class="px-6 py-4">
                            <x-badge-status status="Selesai" />
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="/tracking/098?role={{ request()->query('role', 'staff') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">Detail</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
