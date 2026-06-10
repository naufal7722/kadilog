@extends('layouts.app')

@section('title', 'Dashboard Staff')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Dashboard']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Selamat datang, Staff</h2>
            <p class="text-secondary-500 mt-1">Kelola data operasional KasaLog hari ini.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="/orders/create" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium flex items-center gap-2 shadow-sm shadow-primary-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Order
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat-card title="Order Perlu Diproses" value="{{ number_format($orderPending) }}" icon="order" color="warning" />
        <x-stat-card title="Total Konsumen" value="{{ number_format($totalKonsumen) }}" icon="konsumen" color="primary" />
        <x-stat-card title="Rute Aktif" value="{{ number_format($totalRute) }}" icon="rute" color="info" />
        <x-stat-card title="Operator Tersedia" value="{{ number_format($totalOperator) }}" icon="operator" color="success" />
    </div>

    {{-- Quick Actions --}}
    <h3 class="text-lg font-bold text-secondary-900 mt-8 mb-4">Akses Cepat</h3>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <a href="/suppliers?role=staff" class="flex flex-col items-center justify-center p-4 bg-white border border-secondary-200 rounded-2xl hover:border-primary-300 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <span class="text-sm font-medium text-secondary-700">Kelola Supplier</span>
        </a>
        <a href="/konsumen?role=staff" class="flex flex-col items-center justify-center p-4 bg-white border border-secondary-200 rounded-2xl hover:border-primary-300 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <span class="text-sm font-medium text-secondary-700">Kelola Konsumen</span>
        </a>
        <a href="/operators?role=staff" class="flex flex-col items-center justify-center p-4 bg-white border border-secondary-200 rounded-2xl hover:border-primary-300 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary-100 transition-colors">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <span class="text-sm font-medium text-secondary-700">Kelola Operator</span>
        </a>
        <a href="/pelabuhan?role=staff" class="flex flex-col items-center justify-center p-4 bg-white border border-secondary-200 rounded-2xl hover:border-primary-300 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
            </div>
            <span class="text-sm font-medium text-secondary-700">Kelola Pelabuhan</span>
        </a>
        <a href="/rute?role=staff" class="flex flex-col items-center justify-center p-4 bg-white border border-secondary-200 rounded-2xl hover:border-primary-300 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary-100 transition-colors">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            </div>
            <span class="text-sm font-medium text-secondary-700">Kelola Rute</span>
        </a>
        <a href="/orders?role=staff" class="flex flex-col items-center justify-center p-4 bg-white border border-secondary-200 rounded-2xl hover:border-primary-300 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <span class="text-sm font-medium text-secondary-700">Kelola Order</span>
        </a>
    </div>

    {{-- Recent Orders Table --}}
    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden mt-6">
        <div class="px-6 py-5 border-b border-secondary-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-secondary-900">Order Menunggu Proses</h3>
            <a href="/orders?role=staff" class="text-sm text-primary-600 font-medium hover:text-primary-700">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">No Order</th>
                        <th class="px-6 py-3 font-medium">Supplier</th>
                        <th class="px-6 py-3 font-medium">Tujuan</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    @forelse ($recentOrders as $order)
                    <tr class="table-row-hover">
                        <td class="px-6 py-4">
                            <span class="font-medium text-secondary-900">ORD-{{ $order->kode_order }}</span>
                            <span class="block text-xs text-secondary-500 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-secondary-700">{{ $order->supplier->nama_umkm ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">{{ $order->konsumen->nama_konsumen ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <x-badge-status status="Pending" />
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="/orders/{{ $order->kode_order }}?role=staff" class="inline-flex items-center justify-center p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" data-tooltip="Proses Order">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-secondary-500">
                            Tidak ada order yang menunggu proses.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
