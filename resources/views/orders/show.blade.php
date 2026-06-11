@extends('layouts.app')

@section('title', 'Detail Order')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Transaksi', 'url' => '/orders'], ['label' => 'Detail Order']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h2 class="text-2xl font-bold text-secondary-900">{{ $order->isi_produk }}</h2>
                @php
                    $status = 'Menunggu ACC';
                    if ($order->detailOrders && $order->detailOrders->count() > 0) {
                        $latestDetail = $order->detailOrders->sortByDesc('created_at')->first();
                        $status = $latestDetail->statusDelivery->nama_status_delivery ?? 'Dalam Proses';
                    }
                @endphp
                <x-badge-status :status="$status" />
            </div>
            <p class="text-secondary-500">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }} WIB</p>
        </div>
        <div class="flex gap-2">
            @if(request('role', 'staff') !== 'staff')
            <a href="/tracking/1?role={{ request('role', 'staff') }}" class="px-4 py-2 bg-white border border-secondary-200 text-secondary-700 rounded-xl hover:bg-secondary-50 transition-colors text-sm font-medium shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Live Tracking
            </a>
          
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Detail Pengirim & Penerima --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-secondary-100 shadow-sm">
                <h3 class="text-lg font-bold text-secondary-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Informasi Produk & Packaging
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div class="col-span-2 sm:col-span-4 p-4 bg-primary-50/50 rounded-xl border border-primary-100">
                        <p class="text-sm text-secondary-500 mb-1">Isi Produk</p>
                        <p class="font-semibold text-secondary-900 text-lg">{{ $order->isi_produk }}</p>
                        <p class="text-sm text-secondary-600 mt-2">Keterangan: {{ $order->deskripsi ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-secondary-500 mb-1">Berat</p>
                        <p class="font-medium text-secondary-900">{{ $order->berat }} Kg</p>
                    </div>
                    <div>
                        <p class="text-sm text-secondary-500 mb-1">Dimensi</p>
                        <p class="font-medium text-secondary-900">{{ $order->dimensi ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-secondary-500 mb-1">Kemasan Khusus</p>
                        <p class="font-medium text-secondary-900">
                            @if($order->kemasan == 'iya')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-warning-100 text-warning-800">Iya</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-secondary-100 text-secondary-800">Tidak</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-secondary-500 mb-1">Menggunakan Es</p>
                        <p class="font-medium text-secondary-900">
                            @if($order->es)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary-100 text-primary-800">Iya</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-secondary-100 text-secondary-800">Tidak</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-secondary-100 shadow-sm">
                    <h3 class="text-sm font-bold text-secondary-400 uppercase tracking-wider mb-4">Data Supplier</h3>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-warning-100 flex items-center justify-center text-warning-600 font-bold">
                            S
                        </div>
                        <div>
                            <p class="font-bold text-secondary-900">{{ $order->supplier->nama_pic ?? 'Unknown' }}</p>
                            <p class="text-sm text-secondary-500">{{ $order->supplier->no_hp_pic ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-secondary-100 shadow-sm">
                    <h3 class="text-sm font-bold text-secondary-400 uppercase tracking-wider mb-4">Data Konsumen</h3>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                            K
                        </div>
                        <div>
                            <p class="font-bold text-secondary-900">{{ $order->konsumen->nama_konsumen ?? 'Unknown' }}</p>
                            <p class="text-sm text-secondary-500">{{ $order->konsumen->nama_pic_konsumen ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Rencana Rute Laut --}}
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-secondary-100 shadow-sm">
                <h3 class="text-lg font-bold text-secondary-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Rencana Rute Pelayaran
                </h3>
                
                <div class="relative pl-6 border-l-2 border-primary-200 space-y-6 mt-6 ml-2">
                    {{-- Origin Port --}}
                    <div class="relative">
                        <div class="absolute -left-[33px] top-1 w-4 h-4 rounded-full bg-primary-500 ring-4 ring-white"></div>
                        <p class="text-xs font-bold text-primary-600 uppercase tracking-wider mb-1">Pelabuhan Awal (Pengiriman)</p>
                        <p class="font-semibold text-secondary-900">{{ $order->pelabuhanAwal->nama_pelabuhan ?? $order->pengiriman_awal ?? 'Belum ditentukan' }}</p>
                    </div>

                    {{-- Sea Journey --}}
                    @if($order->detailOrders && $order->detailOrders->count() > 0)
                    @php $latestDetail = $order->detailOrders->first(); @endphp
                    
                    @if($latestDetail->rute && is_array($latestDetail->rute->titik_transit))
                        @foreach($latestDetail->rute->titik_transit as $transitKode)
                        <div class="relative">
                            <div class="absolute -left-[31px] top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-secondary-300 ring-4 ring-white"></div>
                            <div class="bg-white p-3 rounded-xl border border-secondary-100">
                                <p class="text-xs font-semibold text-secondary-500 mb-1">Transit</p>
                                <p class="text-sm font-medium text-secondary-900">{{ isset($semuaPelabuhan[$transitKode]) ? $semuaPelabuhan[$transitKode]->nama_pelabuhan : $transitKode }}</p>
                            </div>
                        </div>
                        @endforeach
                    @endif

                    <div class="relative">
                        <div class="absolute -left-[31px] top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-secondary-300 ring-4 ring-white"></div>
                        <div class="bg-secondary-50 p-3 rounded-xl border border-secondary-100">
                            <p class="text-xs font-semibold text-secondary-600 mb-1">Kapal Penyeberangan</p>
                            <p class="text-sm font-medium text-secondary-900">{{ $latestDetail->operator->nama_operator ?? '-' }}</p>
                        </div>
                    </div>
                    @else
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-secondary-300 ring-4 ring-white"></div>
                        <div class="bg-warning-50 p-3 rounded-xl border border-warning-100">
                            <p class="text-sm font-medium text-warning-900">Menunggu ACC Admin (Belum diassign operator kapal)</p>
                        </div>
                    </div>
                    @endif

                    {{-- Destination Port --}}
                    <div class="relative">
                        <div class="absolute -left-[33px] top-1 w-4 h-4 rounded-full border-2 border-primary-500 bg-white ring-4 ring-white"></div>
                        <p class="text-xs font-bold text-primary-600 uppercase tracking-wider mb-1">Pelabuhan Tujuan</p>
                        <p class="font-semibold text-secondary-900">{{ $order->pelabuhanTujuan->nama_pelabuhan ?? $order->pengiriman_tujuan ?? 'Belum ditentukan' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
