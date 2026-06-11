@extends('layouts.app')

@section('title', 'Dashboard Operator')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Dashboard']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Halo, {{ $operator->nama_operator }}</h2>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-medium bg-success-50 text-success-700 border border-success-200">
                <span class="w-2 h-2 rounded-full bg-success-500 animate-pulse-soft"></span>
                Status: Sedang Bertugas
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat-card title="Menunggu Pickup" value="{{ $menungguPickup }}" icon="order" color="warning" />
        <x-stat-card title="Dalam Pengiriman" value="{{ $dalamPengiriman }}" icon="tracking" color="primary" />
        <x-stat-card title="Selesai Hari Ini" value="{{ $selesaiHariIni }}" icon="order" color="success" />
        <x-stat-card title="Jarak Tempuh (Bulan Ini)" value="{{ $jarakBulanIni }} km" icon="rute" color="info" />
    </div>

    <div class="mt-6">
        {{-- Daftar Tugas --}}
        <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden flex flex-col">
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
            <div class="flex-1 overflow-y-auto max-h-[500px]">
                @forelse($activeDeliveries as $task)
                @php
                    $statusName = $task->statusDelivery->nama_status_delivery ?? 'Pending';
                    $btnLabel = str_contains(strtolower($statusName), 'menunggu') ? 'Pickup Order' : 'Update Status';
                    $ruteDesc = $task->rute && $task->rute->pelabuhanTujuan ? 'Tujuan: Pelabuhan ' . $task->rute->pelabuhanTujuan->nama_pelabuhan : 'Rute tidak diketahui';
                @endphp
                {{-- Task Item --}}
                <div class="p-5 border-b border-secondary-50 hover:bg-secondary-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold text-secondary-900">{{ $task->order->kode_order ?? 'Unknown' }}</span>
                            <x-badge-status status="{{ $statusName }}" />
                        </div>
                        <p class="text-sm font-medium text-secondary-900">{{ $task->order->isi_produk ?? '-' }} ({{ $task->order->berat ?? '0' }}kg)</p>
                        <p class="text-xs text-secondary-500 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $ruteDesc }}
                        </p>
                    </div>
                    <button onclick="openModal('modal-update-status-{{ $task->kode_detail_order }}')" class="shrink-0 px-4 py-2 bg-primary-50 text-primary-600 font-medium rounded-lg hover:bg-primary-100 transition-colors text-sm border border-primary-200">
                        {{ $btnLabel }}
                    </button>
                </div>
                @empty
                <div class="p-8 text-center text-secondary-500">
                    Tidak ada pengiriman aktif.
                </div>
                @endforelse
            </div>
            <div class="p-4 bg-secondary-50 border-t border-secondary-100 text-center">
                <a href="/tracking?role=operator" class="text-sm font-medium text-primary-600 hover:text-primary-700">Lihat Semua Rute Saya →</a>
            </div>
        </div>
    </div>
</div>

@foreach($activeDeliveries as $task)
<x-modal id="modal-update-status-{{ $task->kode_detail_order }}" title="Update Status Pengiriman" maxWidth="max-w-md">
    <form action="{{ route('operator.update-status') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="kode_detail_order" value="{{ $task->kode_detail_order }}">
        
        <div class="p-4 bg-secondary-50 rounded-xl border border-secondary-100 mb-2">
            <p class="text-xs text-secondary-500 mb-1">No. Order</p>
            <p class="font-bold text-secondary-900">{{ $task->order->kode_order ?? 'Unknown' }}</p>
        </div>

        @php
            // We fetch the latest status options from DB, assuming StatusDelivery is passed or we just use a generic select for now. 
            // Wait, we need the available status from StatusDelivery model.
            // Since it's not passed, we can query it directly in view for simplicity, or we should pass it from Controller.
            $statuses = \App\Models\StatusDelivery::pluck('nama_status_delivery', 'kode_status_delivery')->toArray();
        @endphp
        <x-form-input type="select" name="kode_status_delivery" label="Pilih Status Baru" :options="$statuses" required />
        
        <x-form-input type="textarea" name="catatan" label="Catatan Tambahan (Opsional)" placeholder="Misal: Kendala lalu lintas, atau kondisi barang..." />

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-update-status-{{ $task->kode_detail_order }}')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">
                Batal
            </button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm">
                Update Status
            </button>
        </div>
    </form>
</x-modal>
@endforeach
@endsection
