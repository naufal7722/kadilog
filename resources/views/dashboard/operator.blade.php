@extends('layouts.app')

@section('title', 'Dashboard Operator')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Dashboard']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Halo, Budi Santoso</h2>
            <p class="text-secondary-500 mt-1">Area Tugas: Gudang Batam ↔ Pelabuhan Batam</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-medium bg-success-50 text-success-700 border border-success-200">
                <span class="w-2 h-2 rounded-full bg-success-500 animate-pulse-soft"></span>
                Status: Sedang Bertugas
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat-card title="Menunggu Pickup" value="12" icon="order" color="warning" />
        <x-stat-card title="Dalam Pengiriman" value="5" icon="tracking" color="primary" />
        <x-stat-card title="Selesai Hari Ini" value="18" icon="order" color="success" />
        <x-stat-card title="Jarak Tempuh (Bulan Ini)" value="450 km" icon="rute" color="info" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        {{-- Daftar Tugas --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-secondary-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-secondary-900">Daftar Pengiriman Aktif</h3>
                <div class="flex items-center gap-2">
                    <button class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    </button>
                    <button class="p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </button>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto max-h-[400px]">
                {{-- Task Item 1 --}}
                <div class="p-5 border-b border-secondary-50 hover:bg-secondary-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold text-secondary-900">#ORD-2024-105</span>
                            <x-badge-status status="Dalam Perjalanan ke Pelabuhan" />
                        </div>
                        <p class="text-sm font-medium text-secondary-900">Barang Elektronik (15kg)</p>
                        <p class="text-xs text-secondary-500 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Gudang Batam → Pelabuhan Batu Ampar
                        </p>
                    </div>
                    <button onclick="openModal('modal-update-status')" class="shrink-0 px-4 py-2 bg-primary-50 text-primary-600 font-medium rounded-lg hover:bg-primary-100 transition-colors text-sm border border-primary-200">
                        Update Status
                    </button>
                </div>

                {{-- Task Item 2 --}}
                <div class="p-5 border-b border-secondary-50 hover:bg-secondary-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold text-secondary-900">#ORD-2024-106</span>
                            <x-badge-status status="Menunggu Pickup" />
                        </div>
                        <p class="text-sm font-medium text-secondary-900">Pakaian Jadi (40kg)</p>
                        <p class="text-xs text-secondary-500 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Gudang Batam → Pelabuhan Batu Ampar
                        </p>
                    </div>
                    <button onclick="openModal('modal-update-status')" class="shrink-0 px-4 py-2 bg-primary-50 text-primary-600 font-medium rounded-lg hover:bg-primary-100 transition-colors text-sm border border-primary-200">
                        Pickup Order
                    </button>
                </div>
            </div>
            <div class="p-4 bg-secondary-50 border-t border-secondary-100 text-center">
                <a href="/tracking?role=operator" class="text-sm font-medium text-primary-600 hover:text-primary-700">Lihat Semua Rute Saya →</a>
            </div>
        </div>

        {{-- Logbook --}}
        <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm p-6">
            <h3 class="text-lg font-bold text-secondary-900 mb-6">Logbook Hari Ini</h3>
            
            <div class="space-y-0 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-secondary-200 before:to-transparent">
                {{-- Log Item --}}
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active mb-6">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-primary-500 text-white shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-sm relative z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-secondary-100 bg-white shadow-sm">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-bold text-primary-600">10:30</span>
                            <span class="text-[10px] text-secondary-400">#ORD-101</span>
                        </div>
                        <p class="text-sm text-secondary-700">Tiba di Pelabuhan Batu Ampar</p>
                    </div>
                </div>

                {{-- Log Item --}}
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active mb-6">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-secondary-300 text-white shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-sm relative z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-secondary-100 bg-secondary-50 shadow-sm">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-bold text-secondary-500">09:15</span>
                            <span class="text-[10px] text-secondary-400">#ORD-101</span>
                        </div>
                        <p class="text-sm text-secondary-500">Pickup dari Gudang Batam</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Update Status (Mockup) --}}
<x-modal id="modal-update-status" title="Update Status Pengiriman" maxWidth="max-w-md">
    <form class="space-y-6" data-demo-form>
        <div class="p-4 bg-secondary-50 rounded-xl border border-secondary-100 mb-2">
            <p class="text-xs text-secondary-500 mb-1">No. Order</p>
            <p class="font-bold text-secondary-900">#ORD-2024-105</p>
        </div>

        <x-form-input type="select" name="status" label="Pilih Status Baru" :options="['Dalam Perjalanan ke Gudang' => 'Dalam Perjalanan ke Gudang', 'Tiba di Gudang' => 'Tiba di Gudang', 'Dalam Perjalanan ke Pelabuhan' => 'Dalam Perjalanan ke Pelabuhan', 'Tiba di Pelabuhan Tujuan' => 'Tiba di Pelabuhan Tujuan']" required />
        
        <x-form-input type="textarea" name="catatan" label="Catatan Tambahan (Opsional)" placeholder="Misal: Kendala lalu lintas, atau kondisi barang..." />
        
        {{-- File Upload Dummy --}}
        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-secondary-700">Foto Bukti (Opsional)</label>
            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-secondary-300 border-dashed rounded-xl cursor-pointer bg-secondary-50 hover:bg-secondary-100 transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="mb-2 text-sm text-secondary-500"><span class="font-semibold text-primary-600">Klik untuk upload</span> atau drag and drop</p>
                        <p class="text-xs text-secondary-400">PNG, JPG (Max. 2MB)</p>
                    </div>
                </label>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-update-status')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">
                Batal
            </button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm">
                Update Status
            </button>
        </div>
    </form>
</x-modal>
@endsection
