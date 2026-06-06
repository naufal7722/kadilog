@extends('layouts.app')

@section('title', 'Dashboard Supplier')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Dashboard']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-primary rounded-2xl p-6 sm:p-8 text-white relative overflow-hidden shadow-lg shadow-primary-900/20">
        <div class="absolute inset-0">
            <div class="absolute top-10 right-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold mb-2">Halo, PT. Maju Sejahtera!</h2>
                <p class="text-primary-100 max-w-lg text-sm sm:text-base">Pantau status pengiriman barang Anda secara real-time. Buat order pengiriman baru dengan cepat dan mudah.</p>
            </div>
            <button onclick="openModal('modal-buat-order')" class="shrink-0 px-5 py-3 bg-white text-primary-700 font-semibold rounded-xl hover:bg-primary-50 transition-colors shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Order Baru
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <x-stat-card title="Total Order" value="45" icon="order" color="primary" />
        <x-stat-card title="Sedang Dikirim" value="12" icon="tracking" color="warning" />
        <x-stat-card title="Selesai Bulan Ini" value="28" icon="order" color="success" />
    </div>

    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden mt-6">
        <div class="px-6 py-5 border-b border-secondary-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-secondary-900">Pengiriman Aktif Saya</h3>
            <a href="/tracking?role=supplier" class="text-sm text-primary-600 font-medium hover:text-primary-700">Lihat Semua Tracking</a>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Tracking Card 1 --}}
                <div class="border border-secondary-200 rounded-xl p-5 hover:border-primary-300 transition-colors shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="text-xs font-semibold text-primary-600 bg-primary-50 px-2 py-1 rounded-lg">ORD-2024-101</span>
                            <h4 class="text-secondary-900 font-bold mt-2">Sepatu Kulit Lokal (50kg)</h4>
                        </div>
                        <x-badge-status status="Dalam Perjalanan ke Pelabuhan" />
                    </div>
                    <div class="flex items-center gap-3 text-sm text-secondary-500 mb-4">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Batam
                        </div>
                        <svg class="w-4 h-4 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Natuna
                        </div>
                    </div>
                    <div class="pt-4 border-t border-secondary-100 flex justify-between items-center">
                        <p class="text-xs text-secondary-500">Estimasi tiba: <span class="font-medium text-secondary-700">25 Okt 2024</span></p>
                        <a href="/tracking/101?role=supplier" class="text-sm text-primary-600 font-medium hover:text-primary-700">Cek Posisi →</a>
                    </div>
                </div>

                {{-- Tracking Card 2 --}}
                <div class="border border-secondary-200 rounded-xl p-5 hover:border-primary-300 transition-colors shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="text-xs font-semibold text-primary-600 bg-primary-50 px-2 py-1 rounded-lg">ORD-2024-098</span>
                            <h4 class="text-secondary-900 font-bold mt-2">Pakaian Jadi (120kg)</h4>
                        </div>
                        <x-badge-status status="Tiba di Gudang" />
                    </div>
                    <div class="flex items-center gap-3 text-sm text-secondary-500 mb-4">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Batam
                        </div>
                        <svg class="w-4 h-4 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Tanjung Pinang
                        </div>
                    </div>
                    <div class="pt-4 border-t border-secondary-100 flex justify-between items-center">
                        <p class="text-xs text-secondary-500">Estimasi tiba: <span class="font-medium text-secondary-700">22 Okt 2024</span></p>
                        <a href="/tracking/098?role=supplier" class="text-sm text-primary-600 font-medium hover:text-primary-700">Cek Posisi →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Buat Order (Mockup) --}}
<x-modal id="modal-buat-order" title="Buat Order Baru" maxWidth="max-w-2xl">
    <form class="space-y-6" data-demo-form>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form-input name="produk" label="Nama Produk" placeholder="Contoh: Sepatu Kulit Lokal" required />
            <x-form-input type="select" name="kategori" label="Kategori" :options="['Pakaian' => 'Pakaian', 'Makanan' => 'Makanan', 'Elektronik' => 'Elektronik', 'Lainnya' => 'Lainnya']" required />
            
            <div class="col-span-1 md:col-span-2 grid grid-cols-3 gap-4">
                <x-form-input type="number" name="berat" label="Berat (kg)" placeholder="0" required />
                <x-form-input type="number" name="dimensi_p" label="Panjang (cm)" placeholder="0" />
                <x-form-input type="number" name="dimensi_l" label="Lebar (cm)" placeholder="0" />
            </div>

            <div class="col-span-1 md:col-span-2 border-t border-secondary-100 pt-4 mt-2">
                <h4 class="text-sm font-semibold text-secondary-900 mb-4">Tujuan Pengiriman</h4>
            </div>

            <x-form-input type="select" name="konsumen" label="Pilih Konsumen" :options="['1' => 'Toko Laris - Natuna', '2' => 'CV. Abadi - Tanjung Pinang']" required />
            <x-form-input type="select" name="pelabuhan_asal" label="Pelabuhan Asal" :options="['P-BTM1' => 'Pelabuhan Batu Ampar, Batam']" required />
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-buat-order')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">
                Batal
            </button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm">
                Buat Order
            </button>
        </div>
    </form>
</x-modal>
@endsection
