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
                <h2 class="text-2xl sm:text-3xl font-bold mb-2">Halo, {{ $supplier->nama_umkm }}!</h2>
                <p class="text-primary-100 max-w-lg text-sm sm:text-base">Pantau status pengiriman barang Anda secara real-time. Buat order pengiriman baru dengan cepat dan mudah.</p>
            </div>
            <a href="/orders?role=supplier" class="shrink-0 px-5 py-3 bg-white text-primary-700 font-semibold rounded-xl hover:bg-primary-50 transition-colors shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Order Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <x-stat-card title="Total Order" value="{{ $totalOrder }}" icon="order" color="primary" />
        <x-stat-card title="Sedang Dikirim" value="{{ $sedangDikirim }}" icon="tracking" color="warning" />
        <x-stat-card title="Selesai Bulan Ini" value="{{ $selesaiBulanIni }}" icon="order" color="success" />
    </div>

    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden mt-6">
        <div class="px-6 py-5 border-b border-secondary-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-secondary-900">Pengiriman Aktif Saya</h3>
            <a href="/tracking?role=supplier" class="text-sm text-primary-600 font-medium hover:text-primary-700">Lihat Semua Tracking</a>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($activeShipments as $order)
                @php
                    $latestDetail = $order->detailOrders->first();
                    $statusName = $latestDetail->statusDelivery->nama_status_delivery ?? 'Pending';
                    $pelabuhanTujuan = $latestDetail->rute->pelabuhanTujuan->nama_pelabuhan ?? 'Tidak diketahui';
                    // We don't have explicit origin per order hop in this simple schema easily accessible, so we show destination for now
                @endphp
                {{-- Tracking Card --}}
                <div class="border border-secondary-200 rounded-xl p-5 hover:border-primary-300 transition-colors shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="text-xs font-semibold text-primary-600 bg-primary-50 px-2 py-1 rounded-lg">{{ $order->kode_order }}</span>
                            <h4 class="text-secondary-900 font-bold mt-2">{{ $order->isi_produk }} ({{ $order->berat }}kg)</h4>
                        </div>
                        <x-badge-status status="{{ $statusName }}" />
                    </div>
                    <div class="flex items-center gap-3 text-sm text-secondary-500 mb-4">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Tujuan: {{ $pelabuhanTujuan }}
                        </div>
                    </div>
                    <div class="pt-4 border-t border-secondary-100 flex justify-end items-center">
                        <a href="/tracking/{{ $order->kode_order }}?role=supplier" class="text-sm text-primary-600 font-medium hover:text-primary-700">Cek Posisi →</a>
                    </div>
                </div>
                @empty
                <div class="col-span-1 md:col-span-2 text-center py-8 text-secondary-500">
                    Belum ada pengiriman aktif saat ini.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
