@extends('layouts.app')

@section('title', 'Dashboard Superadmin')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Dashboard']]" />
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Dashboard Superadmin</h2>
            <p class="text-secondary-500 mt-1">Ringkasan seluruh aktivitas distribusi KasaLog.</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 bg-white border border-secondary-200 text-secondary-700 rounded-xl hover:bg-secondary-50 transition-colors text-sm font-medium flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export Laporan
            </button>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat-card 
            title="Total Order Aktif" 
            value="{{ $totalOrderAktif }}" 
            icon="order" 
            color="primary" />
            
        <x-stat-card 
            title="Pengiriman Aktif" 
            value="{{ $pengirimanAktif }}" 
            icon="tracking" 
            color="warning" />
            
        <x-stat-card 
            title="Total Supplier" 
            value="{{ number_format($totalSupplier) }}" 
            icon="supplier" 
            color="success" />
            
        <x-stat-card 
            title="Operator Aktif" 
            value="{{ number_format($totalOperator) }}" 
            icon="operator" 
            color="info" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Chart Placeholder --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-secondary-100 shadow-sm p-6 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-secondary-900">Grafik Pengiriman</h3>
                <select class="text-sm border-secondary-200 rounded-lg text-secondary-600 outline-none">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                    <option>Tahun Ini</option>
                </select>
            </div>
            <div class="flex-1 bg-secondary-50 rounded-xl border border-secondary-100 flex items-center justify-center min-h-[300px]">
                <div class="text-center">
                    <svg class="w-12 h-12 text-secondary-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    <p class="text-secondary-500 font-medium">Area Chart Analytics</p>
                    <p class="text-sm text-secondary-400">Library Chart.js / ApexCharts akan dirender di sini.</p>
                </div>
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-secondary-900">Aktivitas Terbaru</h3>
                <a href="/tracking" class="text-sm text-primary-600 font-medium hover:text-primary-700">Lihat Semua</a>
            </div>
            <div class="space-y-6">
                @forelse ($recentActivities as $activity)
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-info-50 text-info-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-secondary-900">Update Pengiriman <span class="text-primary-600">#ORD-{{ $activity->kode_order }}</span></p>
                        <p class="text-xs text-secondary-500 mt-0.5">Status: {{ $activity->statusDelivery->nama_status_delivery ?? 'Unknown' }}</p>
                        <p class="text-xs text-secondary-400 mt-1.5">{{ $activity->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center text-sm text-secondary-500 py-4">Belum ada aktivitas.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
