@extends('layouts.app')

@section('title', 'Tracking Delivery')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Tracking', 'href' => '/tracking']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Tracking Delivery</h2>
            <p class="text-secondary-500 mt-1">Pantau posisi pengiriman barang Anda secara real-time.</p>
        </div>
        
        {{-- Search Resi Khusus di Halaman Tracking --}}
        <form action="/tracking" method="GET" class="relative w-full sm:w-80">
            <input type="hidden" name="role" value="{{ request('role', 'staff') }}">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-primary-500">
                <svg class="w-5 h-5 " fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-24 py-3 bg-white border-2 border-primary-100 rounded-xl text-sm focus:border-primary-500 outline-none shadow-sm transition-colors placeholder:text-secondary-400" placeholder="Masukkan Nomor Order...">
            <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-primary-600 text-white rounded-lg text-xs font-bold hover:bg-primary-700 transition-colors">
                Lacak
            </button>
        </form>
    </div>

    {{-- Daftar Pengiriman Aktif (Grid View) --}}
    <h3 class="text-lg font-bold text-secondary-900 mt-8">Pengiriman Aktif Saat Ini</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        
        @forelse($activeDeliveries as $order)
        <div class="bg-white rounded-2xl border border-secondary-200 shadow-sm overflow-hidden hover:border-primary-300 transition-all flex flex-col group">
            <div class="p-5 border-b border-secondary-100 flex justify-between items-start bg-secondary-50/50">
                <div>
                    <span class="inline-block px-2.5 py-1 bg-white border border-secondary-200 rounded-lg text-xs font-bold text-secondary-800 mb-2 shadow-sm">
                        #{{ $order->kode_order }}
                    </span>
                    <h4 class="font-bold text-secondary-900">{{ $order->isi_produk }}</h4>
                </div>
                <x-badge-status :status="$order->latestStatus" />
            </div>
            
            <div class="p-5 flex-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-1">
                        <p class="text-xs text-secondary-500 mb-0.5">Asal</p>
                        <p class="font-semibold text-secondary-900 text-sm">{{ $order->pelabuhanAwal->nama_pelabuhan ?? $order->pengiriman_awal ?? '-' }}</p>
                    </div>
                    <div class="px-3">
                        <svg class="w-5 h-5 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                    <div class="flex-1 text-right">
                        <p class="text-xs text-secondary-500 mb-0.5">Tujuan Akhir</p>
                        <p class="font-semibold text-secondary-900 text-sm">{{ $order->pelabuhanTujuan->nama_pelabuhan ?? $order->pengiriman_tujuan ?? '-' }}</p>
                    </div>
                </div>

                {{-- Mini Tracking Timeline --}}
                <div class="mt-4 space-y-4 relative before:absolute before:inset-0 before:ml-2.5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-secondary-200 before:to-transparent">
                    @php
                        $latestDetail = $order->detailOrders->first();
                        $histories = $latestDetail ? $latestDetail->histories : collect();
                    @endphp
                    @forelse($histories as $history)
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <!-- Icon -->
                        <div class="flex items-center justify-center w-6 h-6 rounded-full border-2 border-white bg-primary-100 text-primary-600 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <div class="w-2 h-2 rounded-full bg-primary-600"></div>
                        </div>
                        <!-- Card -->
                        <div class="w-[calc(100%-2rem)] md:w-[calc(50%-1.5rem)] p-3 rounded-xl border border-secondary-100 bg-white shadow-sm">
                            <div class="flex items-center justify-between mb-1">
                                <h5 class="font-bold text-secondary-900 text-xs">{{ $history->statusDelivery->nama_status_delivery ?? 'Status' }}</h5>
                                <time class="text-[10px] text-secondary-400 font-medium">{{ $history->created_at->format('H:i') }}</time>
                            </div>
                            @if($history->catatan)
                            <p class="text-[11px] text-secondary-500">{{ $history->catatan }}</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-secondary-500 text-center">Belum ada riwayat update status.</p>
                    @endforelse
                </div>
            </div>

            <div class="p-4 bg-secondary-50/50 border-t border-secondary-100">
                <a href="/orders/{{ $order->kode_order }}?role={{ request()->query('role', 'staff') }}" class="flex justify-center items-center w-full py-2 bg-white border border-secondary-200 rounded-lg text-sm font-semibold text-primary-600 hover:bg-primary-50 hover:border-primary-200 transition-colors">
                    Lihat Detail Tracking
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-8 text-center bg-secondary-50 rounded-2xl border border-secondary-200 border-dashed">
            <svg class="w-12 h-12 text-secondary-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            <p class="text-secondary-500 font-medium">Tidak ada pengiriman yang sedang aktif saat ini.</p>
        </div>
        @endforelse
    </div>
    
    {{-- Riwayat Selesai --}}
    <h3 class="text-lg font-bold text-secondary-900 mt-8 mb-4">Riwayat Pengiriman Selesai</h3>
    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">No. Order / Waktu Selesai</th>
                        <th class="px-6 py-3 font-medium">Barang</th>
                        <th class="px-6 py-3 font-medium">Rute</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    @forelse($completedDeliveries as $order)
                    <tr class="table-row-hover">
                        <td class="px-6 py-4">
                            <span class="font-bold text-secondary-900">#{{ $order->kode_order }}</span>
                            <span class="block text-xs text-secondary-500 mt-1">{{ $order->latestUpdatedAt->format('d M Y, H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-secondary-900">{{ $order->isi_produk }}</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">{{ $order->pelabuhanAwal->nama_pelabuhan ?? $order->pengiriman_awal ?? '-' }} → {{ $order->pelabuhanTujuan->nama_pelabuhan ?? $order->pengiriman_tujuan ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <x-badge-status :status="$order->latestStatus" />
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="/orders/{{ $order->kode_order }}?role={{ request()->query('role', 'staff') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-secondary-500">
                            Belum ada riwayat pengiriman selesai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
