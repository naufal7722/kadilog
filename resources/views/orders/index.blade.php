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
                            <div class="font-mono text-sm font-semibold text-primary-700">{{ $order->kode_order }}</div>
                            <div class="text-sm font-medium text-secondary-900 mt-1">{{ $order->isi_produk }}</div>
                            <div class="text-xs text-secondary-500 mt-0.5">{{ $order->berat }} Kg • Es: {{ $order->es ? 'Ya' : 'Tidak' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-secondary-900">{{ $order->kode_supplier }} ({{ $order->supplier->nama_pic ?? 'Unknown' }})</div>
                            <svg class="w-3 h-3 text-secondary-400 my-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                            <div class="text-sm text-secondary-700">{{ $order->kode_konsumen }} ({{ $order->konsumen->nama_konsumen ?? 'Unknown' }})</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 bg-secondary-100 text-secondary-700 text-xs rounded-md">{{ $order->pengiriman_awal ?? '-' }}</span>
                                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                <span class="px-2 py-1 bg-secondary-100 text-secondary-700 text-xs rounded-md">{{ $order->pengiriman_tujuan ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $status = 'Menunggu ACC';
                                if ($order->detailOrders && $order->detailOrders->count() > 0) {
                                    $latestDetail = $order->detailOrders->first();
                                    $status = $latestDetail->statusDelivery->nama_status_delivery ?? 'Dalam Proses';
                                }
                            @endphp
                            <x-badge-status :status="$status" />
                        </td>
                        <td class="px-6 py-4 text-right space-x-1 flex justify-end items-center">
                            @if(in_array(request('role', 'staff'), ['staff', 'superadmin']))
                            <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-success-50 border border-success-200 rounded-lg text-sm font-medium text-success-700 hover:bg-success-100 hover:text-success-800 transition-colors shadow-sm mr-2" onclick="openAccModal('{{ $order->kode_order }}', '{{ $order->kode_supplier }}')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                ACC Order
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
                <label class="block text-sm font-medium text-secondary-700 mb-1">Pilih Rute Pelayaran <span class="text-danger-500">*</span></label>
                <select name="kode_rute" class="w-full px-3.5 py-2.5 bg-white border border-secondary-300 rounded-xl text-sm text-secondary-700 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none" required>
                    <option value="">Pilih Rute...</option>
                    @foreach($rutes ?? [] as $rute)
                        <option value="{{ $rute->kode_rute }}">{{ $rute->kode_rute }} - Menuju {{ $rute->pelabuhan->nama_pelabuhan ?? 'Unknown' }} ({{ $rute->jarak }} mil)</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-secondary-700 mb-1">Assign Operator / Kapal <span class="text-danger-500">*</span></label>
                <select name="kode_operator" class="w-full px-3.5 py-2.5 bg-white border border-secondary-300 rounded-xl text-sm text-secondary-700 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none" required>
                    <option value="">Pilih Operator...</option>
                    @foreach($operators ?? [] as $operator)
                        <option value="{{ $operator->kode_operator }}">{{ $operator->kode_operator }} - {{ $operator->nama_operator }}</option>
                    @endforeach
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

@section('scripts')
<script>
    function openAccModal(kodeOrder, kodeSupplier) {
        document.getElementById('acc-kode-order').textContent = kodeOrder;
        document.getElementById('input_kode_order').value = kodeOrder;
        document.getElementById('input_kode_supplier').value = kodeSupplier;
        openModal('modal-acc');
    }
</script>
@endsection
@endsection
