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
                    @forelse($orders as $order)
                    <tr class="table-row-hover">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-secondary-900 mt-1">{{ $order->isi_produk }}</div>
                            <div class="text-xs text-secondary-500 mt-0.5">{{ $order->berat }} Kg • Es: {{ $order->es ? 'Ya' : 'Tidak' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-secondary-900">{{ $order->supplier->nama_pic ?? 'Unknown' }}</div>
                            <svg class="w-3 h-3 text-secondary-400 my-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                            <div class="text-sm text-secondary-700">{{ $order->konsumen->nama_konsumen ?? 'Unknown' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 bg-secondary-100 text-secondary-700 text-xs rounded-md">{{ $order->pelabuhanAwal->nama_pelabuhan ?? $order->pengiriman_awal ?? '-' }}</span>
                                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                <span class="px-2 py-1 bg-secondary-100 text-secondary-700 text-xs rounded-md">{{ $order->pelabuhanTujuan->nama_pelabuhan ?? $order->pengiriman_tujuan ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $status = 'Menunggu ACC';
                                if ($order->is_cancelled) {
                                    $status = 'Dibatalkan';
                                } elseif ($order->detailOrders && $order->detailOrders->count() > 0) {
                                    $latestDetail = $order->detailOrders->sortByDesc('created_at')->first();
                                    $status = $latestDetail->statusDelivery->nama_status_delivery ?? 'Dalam Proses';
                                }
                            @endphp
                            <x-badge-status :status="$status" />
                        </td>
                        <td class="px-6 py-4 text-right space-x-1 flex justify-end items-center">
                            @if(in_array(request('role', 'staff'), ['staff', 'superadmin']) && !$order->is_cancelled && (!$order->detailOrders || $order->detailOrders->count() === 0))
                            <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-success-50 border border-success-200 rounded-lg text-sm font-medium text-success-700 hover:bg-success-100 hover:text-success-800 transition-colors shadow-sm mr-2" onclick="openAccModal('{{ $order->kode_order }}', '{{ $order->kode_supplier }}', '{{ $order->pengiriman_awal }}')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                ACC Order
                            </button>
                            @endif

                            @if(request('role') == 'supplier' && !$order->is_cancelled && (!$order->detailOrders || $order->detailOrders->count() === 0))
                            <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-warning-50 border border-warning-200 rounded-lg text-sm font-medium text-warning-700 hover:bg-warning-100 hover:text-warning-800 transition-colors shadow-sm mr-2" data-order="{{ base64_encode(json_encode($order)) }}" onclick="openEditOrderModal(this.dataset.order)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </button>
                            <button type="button" onclick="handleCancel('{{ $order->kode_order }}', '{{ addslashes($order->isi_produk) }}')" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-secondary-100 border border-secondary-200 rounded-lg text-sm font-medium text-secondary-700 hover:bg-secondary-200 hover:text-secondary-800 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Batalkan
                            </button>
                            @endif
                            
                            <a href="/orders/{{ $order->kode_order }}?role={{ request('role', 'staff') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-secondary-200 rounded-lg text-sm font-medium text-secondary-700 hover:bg-secondary-50 hover:text-primary-600 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-secondary-500">
                            Belum ada data order.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(request('role') == 'supplier')
<x-modal id="modal-form" title="Buat Order Baru" maxWidth="max-w-2xl">
    <form action="/orders?role={{ request('role') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Bagian Kiri: Info Umum & Barang --}}
            <div class="space-y-5">
                <h4 class="text-sm font-bold text-secondary-900 border-b border-secondary-100 pb-2">Informasi Produk</h4>
                
                <div class="mb-4">
                    <label for="kode_konsumen" class="block text-sm font-medium text-secondary-700 mb-2">Kode Konsumen (Penerima)</label>
                    <select name="kode_konsumen" id="kode_konsumen" class="w-full px-3.5 py-2.5 bg-white border border-secondary-300 rounded-xl text-sm text-secondary-700 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none" required>
                        <option value="">Pilih Pelabuhan Tujuan terlebih dahulu...</option>
                    </select>
                </div>
                <x-form-input name="isi_produk" label="Isi Produk" placeholder="Misal: Ikan Segar" required />
                
                <x-form-input type="number" name="berat" label="Berat (Kg)" placeholder="0" required />
                
                <div>
                    <label class="block text-sm font-medium text-secondary-700 mb-1">Dimensi (PxLxT) cm <span class="text-danger-500">*</span></label>
                    <div class="flex gap-2">
                        <input type="number" name="panjang" placeholder="P" required class="w-full px-3 py-2 border border-secondary-200 rounded-lg text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                        <span class="text-secondary-400 self-center">x</span>
                        <input type="number" name="lebar" placeholder="L" required class="w-full px-3 py-2 border border-secondary-200 rounded-lg text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                        <span class="text-secondary-400 self-center">x</span>
                        <input type="number" name="tinggi" placeholder="T" required class="w-full px-3 py-2 border border-secondary-200 rounded-lg text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    </div>
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
                    @if(isset($pelabuhanAwalOptions) && $pelabuhanAwalOptions->count() > 0)
                        <x-form-input type="select" name="pengiriman_awal" label="Pelabuhan Awal (Asal)" :options="$pelabuhanAwalOptions->pluck('nama_pelabuhan', 'kode_pelabuhan')->toArray()" required />
                    @else
                        <x-form-input type="select" name="pengiriman_awal" label="Pelabuhan Awal (Asal)" :options="$semuaPelabuhan->pluck('nama_pelabuhan', 'kode_pelabuhan')->toArray()" required />
                    @endif
                    
                    <div class="flex justify-center -my-3 relative z-10">
                        <div class="bg-white p-1 rounded-full border border-primary-200 text-primary-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </div>
                    </div>

                    <x-form-input type="select" name="pengiriman_tujuan" label="Pelabuhan Tujuan" :options="$pelabuhanTujuanOptions ? collect($pelabuhanTujuanOptions)->pluck('nama_pelabuhan', 'kode_pelabuhan')->toArray() : []" required />
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-form')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm">Simpan & Buat Order</button>
        </div>
    </form>
</x-modal>

<x-modal id="modal-edit-order" title="Edit Order" maxWidth="max-w-2xl">
    <form id="form-edit-order" action="" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Bagian Kiri: Info Umum & Barang --}}
            <div class="space-y-5">
                <h4 class="text-sm font-bold text-secondary-900 border-b border-secondary-100 pb-2">Informasi Produk</h4>
                
                <div class="mb-4">
                    <label for="edit_kode_konsumen" class="block text-sm font-medium text-secondary-700 mb-2">Kode Konsumen (Penerima)</label>
                    <select name="kode_konsumen" id="edit_kode_konsumen" class="w-full px-3.5 py-2.5 bg-white border border-secondary-300 rounded-xl text-sm text-secondary-700 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none" required>
                        <option value="">Pilih Pelabuhan Tujuan terlebih dahulu...</option>
                    </select>
                </div>
                <x-form-input name="isi_produk" id="edit_isi_produk" label="Isi Produk" placeholder="Misal: Ikan Segar" required />
                
                <x-form-input type="number" name="berat" id="edit_berat" label="Berat (Kg)" placeholder="0" required />
                
                <div>
                    <label class="block text-sm font-medium text-secondary-700 mb-1">Dimensi (PxLxT) cm <span class="text-danger-500">*</span></label>
                    <div class="flex gap-2">
                        <input type="number" name="panjang" id="edit_panjang" placeholder="P" required class="w-full px-3 py-2 border border-secondary-200 rounded-lg text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                        <span class="text-secondary-400 self-center">x</span>
                        <input type="number" name="lebar" id="edit_lebar" placeholder="L" required class="w-full px-3 py-2 border border-secondary-200 rounded-lg text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                        <span class="text-secondary-400 self-center">x</span>
                        <input type="number" name="tinggi" id="edit_tinggi" placeholder="T" required class="w-full px-3 py-2 border border-secondary-200 rounded-lg text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    </div>
                </div>
                
                <x-form-input type="textarea" name="deskripsi" id="edit_deskripsi" label="Deskripsi / Catatan" rows="2" />
            </div>

            {{-- Bagian Kanan: Packaging & Rute Laut --}}
            <div class="space-y-5">
                <h4 class="text-sm font-bold text-secondary-900 border-b border-secondary-100 pb-2">Packaging & Rute</h4>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-secondary-700 mb-2">Butuh Kemasan Khusus?</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="kemasan" id="edit_kemasan_iya" value="iya" class="text-primary-600 focus:ring-primary-500">
                                <span class="text-sm text-secondary-700">Iya</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="kemasan" id="edit_kemasan_tidak" value="tidak" class="text-primary-600 focus:ring-primary-500">
                                <span class="text-sm text-secondary-700">Tidak</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-secondary-700 mb-2">Menggunakan Es?</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="es" id="edit_es_iya" value="iya" class="text-primary-600 focus:ring-primary-500">
                                <span class="text-sm text-secondary-700">Iya</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="es" id="edit_es_tidak" value="tidak" class="text-primary-600 focus:ring-primary-500">
                                <span class="text-sm text-secondary-700">Tidak</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-warning-50/50 border border-warning-100 rounded-xl space-y-4">
                    @if(isset($pelabuhanAwalOptions) && $pelabuhanAwalOptions->count() > 0)
                        <x-form-input type="select" id="edit_pengiriman_awal" name="pengiriman_awal" label="Pelabuhan Awal (Asal)" :options="$pelabuhanAwalOptions->pluck('nama_pelabuhan', 'kode_pelabuhan')->toArray()" required />
                    @else
                        <x-form-input type="select" id="edit_pengiriman_awal" name="pengiriman_awal" label="Pelabuhan Awal (Asal)" :options="$semuaPelabuhan->pluck('nama_pelabuhan', 'kode_pelabuhan')->toArray()" required />
                    @endif
                    
                    <div class="flex justify-center -my-3 relative z-10">
                        <div class="bg-white p-1 rounded-full border border-warning-200 text-warning-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </div>
                    </div>

                    <x-form-input type="select" id="edit_pengiriman_tujuan" name="pengiriman_tujuan" label="Pelabuhan Tujuan" :options="$pelabuhanTujuanOptions ? collect($pelabuhanTujuanOptions)->pluck('nama_pelabuhan', 'kode_pelabuhan')->toArray() : []" required />
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-edit-order')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm">Simpan Perubahan</button>
        </div>
    </form>
</x-modal>
@endif
@if(in_array(request('role', 'staff'), ['staff', 'superadmin']))
<x-modal id="modal-acc" title="ACC Order & Assign Pengiriman" maxWidth="max-w-xl">
    <form action="/orders/acc?role={{ request('role', 'staff') }}" method="POST" class="space-y-5">
        @csrf
        <div class="bg-primary-50 rounded-xl p-4 flex items-start gap-4 border border-primary-100">
            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 mt-0.5 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div>
                <h4 class="font-bold text-primary-900" id="acc-kode-order">ORD-XXX</h4>
                <p class="text-sm text-primary-700 mt-1">Lengkapi data rute dan operator kapal untuk memulai proses pengiriman ini.</p>
            </div>
        </div>

        <input type="hidden" name="kode_order" id="input_kode_order">
        <input type="hidden" name="kode_supplier" id="input_kode_supplier">
        
        <div class="space-y-4">


            <div>
                <label class="block text-sm font-medium text-secondary-700 mb-1">Assign Operator / Kapal <span class="text-danger-500">*</span></label>
                <select name="kode_operator" class="w-full px-3.5 py-2.5 bg-white border border-secondary-300 rounded-xl text-sm text-secondary-700 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none" required>
                    <option value="">Pilih Operator...</option>
                    <!-- Options populated by Javascript -->
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-secondary-700 mb-1">Status Awal Pengiriman <span class="text-danger-500">*</span></label>
                <select name="kode_status_delivery" class="w-full px-3.5 py-2.5 bg-white border border-secondary-300 rounded-xl text-sm text-secondary-700 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none" required>
                    @foreach($statuses ?? [] as $status)
                        <option value="{{ $status->kode_status_delivery }}" {{ stripos($status->nama_status_delivery, 'menunggu') !== false ? 'selected' : '' }}>
                            {{ $status->nama_status_delivery }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-acc')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-success-600 rounded-xl hover:bg-success-700 transition-colors shadow-sm">Simpan & Proses Order</button>
        </div>
    </form>
</x-modal>
@endif

{{-- Hidden Delete Form --}}
<form id="delete-form" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@section('scripts')
<script>
    function openAccModal(kodeOrder, kodeSupplier, pengirimanAwal) {
        document.getElementById('acc-kode-order').textContent = kodeOrder;
        document.getElementById('input_kode_order').value = kodeOrder;
        document.getElementById('input_kode_supplier').value = kodeSupplier;

        const semuaOperators = @json($operators ?? []);
        const operatorSelect = document.querySelector('select[name="kode_operator"]');
        
        // Kosongkan dan filter operator berdasarkan pengiriman_awal
        operatorSelect.innerHTML = '<option value="">Pilih Operator...</option>';
        const filteredOperators = semuaOperators.filter(o => o.kode_pelabuhan == pengirimanAwal);
        
        if (filteredOperators.length > 0) {
            filteredOperators.forEach(o => {
                const option = document.createElement('option');
                option.value = o.kode_operator;
                option.textContent = o.kode_operator + ' - ' + o.nama_operator;
                operatorSelect.appendChild(option);
            });
        } else {
            operatorSelect.innerHTML = '<option value="">Tidak ada operator di pelabuhan ini</option>';
        }

        openModal('modal-acc');
    }

    function openEditOrderModal(encodedOrder) {
        let order;
        try {
            order = JSON.parse(atob(encodedOrder));
        } catch (e) {
            console.error("Failed to parse order JSON", e);
            return;
        }

        document.getElementById('form-edit-order').action = '/orders/' + order.kode_order + '?role=supplier';
        
        document.getElementById('edit_isi_produk').value = order.isi_produk;
        document.getElementById('edit_berat').value = order.berat;
        if (order.dimensi) {
            const dimensiParts = order.dimensi.split('x');
            document.getElementById('edit_panjang').value = dimensiParts[0] || '';
            document.getElementById('edit_lebar').value = dimensiParts[1] || '';
            document.getElementById('edit_tinggi').value = dimensiParts[2] || '';
        }
        document.getElementById('edit_deskripsi').value = order.deskripsi || '';
        
        if (order.kemasan == 'iya' || order.kemasan == '1') {
            document.getElementById('edit_kemasan_iya').checked = true;
        } else {
            document.getElementById('edit_kemasan_tidak').checked = true;
        }

        if (order.es == 'iya' || order.es == '1' || order.es == true) {
            document.getElementById('edit_es_iya').checked = true;
        } else {
            document.getElementById('edit_es_tidak').checked = true;
        }

        document.getElementById('edit_pengiriman_awal').value = order.pengiriman_awal;
        
        const pelabuhanTujuanSelect = document.getElementById('edit_pengiriman_tujuan');
        pelabuhanTujuanSelect.value = order.pengiriman_tujuan;
        
        // Trigger change to populate konsumen based on selected tujuan
        pelabuhanTujuanSelect.dispatchEvent(new Event('change'));
        
        // Timeout to wait for the options to be populated before setting the value
        setTimeout(() => {
            document.getElementById('edit_kode_konsumen').value = order.kode_konsumen;
        }, 100);

        openModal('modal-edit-order');
    }

    function handleCancel(kodeOrder, isiProduk) {
        // Build a custom modal for cancel confirmation
        const modalHtml = `
            <div id="cancel-confirm-modal" data-modal-backdrop class="fixed inset-0 z-50 flex items-center justify-center modal-backdrop">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 animate-scale-in">
                    <div class="p-6 text-center">
                        <div class="mx-auto w-14 h-14 rounded-full bg-warning-50 flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-secondary-900 mb-2">Batalkan Order</h3>
                        <p class="text-secondary-500 text-sm">Apakah Anda yakin ingin membatalkan pesanan <strong class="text-secondary-700">${isiProduk}</strong>? Pesanan yang dibatalkan tidak akan diproses lebih lanjut.</p>
                    </div>
                    <div class="flex gap-3 px-6 pb-6">
                        <button onclick="document.getElementById('cancel-confirm-modal').remove(); document.body.style.overflow='';" class="flex-1 px-4 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">
                            Kembali
                        </button>
                        <button id="confirm-cancel-btn" class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-warning-500 rounded-xl hover:bg-warning-600 transition-colors">
                            Ya, Batalkan
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHtml);
        document.body.style.overflow = 'hidden';

        document.getElementById('confirm-cancel-btn').addEventListener('click', function () {
            document.getElementById('cancel-confirm-modal').remove();
            document.body.style.overflow = '';
            const form = document.getElementById('delete-form');
            form.action = '/orders/' + kodeOrder + '?role=supplier';
            form.submit();
        });

        document.getElementById('cancel-confirm-modal').addEventListener('click', function (e) {
            if (e.target === this) {
                this.remove();
                document.body.style.overflow = '';
            }
        });
    }

    @if(request('role') == 'supplier')
    document.addEventListener('DOMContentLoaded', function() {
        const semuaKonsumen = @json($semuaKonsumen ?? []);
        const semuaPelabuhan = @json($semuaPelabuhan ?? []);

        function initKonsumenDropdown(tujuanSelectId, konsumenSelectId) {
            const pelabuhanTujuanSelect = document.getElementById(tujuanSelectId);
            const konsumenSelect = document.getElementById(konsumenSelectId);
            
            if (pelabuhanTujuanSelect && konsumenSelect) {
                pelabuhanTujuanSelect.addEventListener('change', function() {
                    const selectedPelabuhanKode = this.value;
                    const targetPelabuhan = semuaPelabuhan.find(p => p.kode_pelabuhan == selectedPelabuhanKode);
                    
                    konsumenSelect.innerHTML = '<option value="">Pilih Konsumen...</option>';
                    
                    if (targetPelabuhan) {
                        const targetPulau = targetPelabuhan.nama_pulau;
                        const filteredKonsumen = semuaKonsumen.filter(k => k.pelabuhan && k.pelabuhan.nama_pulau === targetPulau);
                        
                        if (filteredKonsumen.length > 0) {
                            filteredKonsumen.forEach(k => {
                                const option = document.createElement('option');
                                option.value = k.kode_konsumen;
                                option.textContent = k.nama_konsumen + ' (PIC: ' + k.nama_pic_konsumen + ')';
                                konsumenSelect.appendChild(option);
                            });
                        } else {
                            konsumenSelect.innerHTML = '<option value="">Tidak ada konsumen di wilayah ini</option>';
                        }
                    }
                });

                if (pelabuhanTujuanSelect.value) {
                    pelabuhanTujuanSelect.dispatchEvent(new Event('change'));
                }
            }
        }

        // Initialize for Create Form (tujuan is by default named pengiriman_tujuan, konsumen is kode_konsumen)
        const createTujuanSelect = document.querySelector('#modal-form select[name="pengiriman_tujuan"]');
        if (createTujuanSelect) createTujuanSelect.id = 'create_pengiriman_tujuan';
        
        initKonsumenDropdown('create_pengiriman_tujuan', 'kode_konsumen');
        
        // Initialize for Edit Form
        initKonsumenDropdown('edit_pengiriman_tujuan', 'edit_kode_konsumen');
    });
    @endif
</script>
@endsection
@endsection
