@extends('layouts.app')

@section('title', 'Daftar Order')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Transaksi'], ['label' => 'Order Pengiriman']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Order Pengiriman Laut</h2>
            <p class="text-secondary-500 mt-1">Kelola data pengiriman barang dari supplier ke konsumen antarpulau.</p>
        </div>
        
        @if(request('role') == 'supplier')
        <button onclick="openModal('modal-form')" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Order Baru
        </button>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-secondary-100 bg-secondary-50/50 flex flex-wrap gap-4 items-center justify-between">
            <div class="flex items-center gap-2">
                <select class="px-3 py-2 bg-white border border-secondary-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <option>Semua Status</option>
                    <option>Menunggu Kapal</option>
                    <option>Proses Pengiriman Laut</option>
                    <option>Tiba di Tujuan</option>
                </select>
            </div>
            <div class="relative max-w-xs w-full">
                <input type="text" placeholder="Cari Kode Order..." class="w-full pl-9 pr-4 py-2 border border-secondary-200 rounded-lg text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                <svg class="w-4 h-4 text-secondary-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50/50 text-secondary-500 text-xs uppercase tracking-wider border-b border-secondary-100">
                        <th class="px-6 py-4 font-medium">Order & Produk</th>
                        <th class="px-6 py-4 font-medium">Supplier → Konsumen</th>
                        <th class="px-6 py-4 font-medium">Rute Kapal</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    <tr class="table-row-hover">
                        <td class="px-6 py-4">
                            <div class="font-mono text-sm font-semibold text-primary-700">ORD-202310-001</div>
                            <div class="text-sm font-medium text-secondary-900 mt-1">Ikan Tuna Beku</div>
                            <div class="text-xs text-secondary-500 mt-0.5">150 Kg • Es: Ya</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-secondary-900">SUP-01 (Bpk. Ahmad)</div>
                            <svg class="w-3 h-3 text-secondary-400 my-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                            <div class="text-sm text-secondary-700">KON-001 (Toko Laris Manis)</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 bg-secondary-100 text-secondary-700 text-xs rounded-md">P-NTN1</span>
                                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                <span class="px-2 py-1 bg-secondary-100 text-secondary-700 text-xs rounded-md">P-BTM1</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <x-badge-status status="Proses Pengiriman Laut" />
                        </td>
                        <td class="px-6 py-4 text-right space-x-1 flex justify-end items-center">
                            @if(request('role') == 'superadmin')
                            <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-success-50 border border-success-200 rounded-lg text-sm font-medium text-success-700 hover:bg-success-100 hover:text-success-800 transition-colors shadow-sm mr-2" onclick="alert('Order ACC berhasil di-klik!')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                ACC Order
                            </button>
                            @endif
                            
                            <a href="/orders/1?role={{ request('role', 'staff') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-secondary-200 rounded-lg text-sm font-medium text-secondary-700 hover:bg-secondary-50 hover:text-primary-600 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(request('role') == 'supplier')
<x-modal id="modal-form" title="Buat Order Baru" maxWidth="max-w-2xl">
    <form class="space-y-6" data-demo-form>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Bagian Kiri: Info Umum & Barang --}}
            <div class="space-y-5">
                <h4 class="text-sm font-bold text-secondary-900 border-b border-secondary-100 pb-2">Informasi Produk</h4>
                
                <x-form-input name="kode_konsumen" label="Kode Konsumen (Penerima)" placeholder="Misal: KON-001" required />
                <x-form-input name="isi_produk" label="Isi Produk" placeholder="Misal: Ikan Segar" required />
                
                <div class="grid grid-cols-2 gap-3">
                    <x-form-input type="number" name="berat" label="Berat (Kg)" placeholder="0" required />
                    <x-form-input name="dimensi" label="Dimensi (PxLxT)" placeholder="Misal: 50x50x50 cm" required />
                </div>
                
                <x-form-input type="textarea" name="deskripsi" label="Deskripsi / Catatan" rows="2" />
            </div>

            {{-- Bagian Kanan: Packaging & Rute Laut --}}
            <div class="space-y-5">
                <h4 class="text-sm font-bold text-secondary-900 border-b border-secondary-100 pb-2">Packaging & Rute</h4>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-secondary-700 mb-2">Butuh Kemasan Khusus?</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="kemasan" value="iya" class="text-primary-600 focus:ring-primary-500">
                                <span class="text-sm text-secondary-700">Iya</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="kemasan" value="tidak" class="text-primary-600 focus:ring-primary-500" checked>
                                <span class="text-sm text-secondary-700">Tidak</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-secondary-700 mb-2">Menggunakan Es?</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="es" value="iya" class="text-primary-600 focus:ring-primary-500">
                                <span class="text-sm text-secondary-700">Iya</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="es" value="tidak" class="text-primary-600 focus:ring-primary-500" checked>
                                <span class="text-sm text-secondary-700">Tidak</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-primary-50/50 border border-primary-100 rounded-xl space-y-4">
                    <x-form-input type="select" name="pengiriman_awal" label="Pelabuhan Awal (Asal)" :options="['P-NTN1' => 'Pelabuhan Selat Lampa (Natuna)', 'P-BTM1' => 'Pelabuhan Batu Ampar (Batam)']" required />
                    
                    <div class="flex justify-center -my-3 relative z-10">
                        <div class="bg-white p-1 rounded-full border border-primary-200 text-primary-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </div>
                    </div>

                    <x-form-input type="select" name="pengiriman_tujuan" label="Pelabuhan Tujuan" :options="['P-BTM1' => 'Pelabuhan Batu Ampar (Batam)', 'P-NTN1' => 'Pelabuhan Selat Lampa (Natuna)']" required />
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-form')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm">Simpan & Buat Order</button>
        </div>
    </form>
</x-modal>
@endif
@endsection
