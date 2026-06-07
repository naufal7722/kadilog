@extends('layouts.app')

@section('title', 'Detail Tracking')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Tracking', 'url' => '/tracking'], ['label' => 'Detail Tracking']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h2 class="text-2xl font-bold text-secondary-900">ORD-202310-001</h2>
                <span class="px-2.5 py-1 bg-primary-100 text-primary-700 text-xs font-semibold rounded-lg border border-primary-200">
                    Ikan Tuna Beku (150 Kg)
                </span>
            </div>
            <p class="text-secondary-500">
                Dari: <span class="font-medium text-secondary-700">Pelabuhan Selat Lampa (Natuna)</span> → 
                Tujuan: <span class="font-medium text-secondary-700">Pelabuhan Batu Ampar (Batam)</span>
            </p>
        </div>
        
        @if(in_array(request('role', 'staff'), ['operator', 'superadmin']))
        <button onclick="openModal('modal-update-status')" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2 h-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Update Status
        </button>
        @endif
    </div>

    {{-- Progress Bar (Laut) --}}
    <div class="bg-white p-6 rounded-2xl border border-secondary-100 shadow-sm">
        <div class="relative pt-8 pb-4">
            {{-- Base Line --}}
            <div class="absolute top-10 left-0 w-full h-1 bg-secondary-100 rounded-full"></div>
            {{-- Active Line --}}
            <div class="absolute top-10 left-0 w-1/2 h-1 bg-primary-500 rounded-full"></div>
            
            <div class="relative flex justify-between">
                <div class="flex flex-col items-center">
                    <div class="w-4 h-4 rounded-full bg-primary-500 ring-4 ring-white mb-2 relative z-10"></div>
                    <p class="text-xs font-bold text-secondary-900 mt-1">Order Dibuat</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-4 h-4 rounded-full bg-primary-500 ring-4 ring-white mb-2 relative z-10"></div>
                    <p class="text-xs font-bold text-secondary-900 mt-1">Berangkat</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-4 h-4 rounded-full bg-secondary-200 ring-4 ring-white mb-2 relative z-10">
                        <div class="absolute inset-0 bg-primary-500 rounded-full animate-ping opacity-75"></div>
                    </div>
                    <p class="text-xs font-bold text-primary-600 mt-1">Di Perjalanan (Laut)</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-4 h-4 rounded-full bg-secondary-200 ring-4 ring-white mb-2 relative z-10"></div>
                    <p class="text-xs font-medium text-secondary-400 mt-1">Tiba di Tujuan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-2xl border border-secondary-100 shadow-sm">
                <h3 class="text-lg font-bold text-secondary-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Timeline Perjalanan
                </h3>
                
                <div class="relative pl-4 sm:pl-6 ml-2 space-y-8 border-l-2 border-secondary-200">
                    
                    {{-- Timeline Item 1: Order Dibuat --}}
                    <div class="relative">
                        <div class="absolute -left-[25px] sm:-left-[33px] top-1 w-4 h-4 rounded-full bg-primary-500 ring-4 ring-white"></div>
                        <p class="text-sm text-secondary-500 mb-1">24 Okt 2023, 08:30 WIB</p>
                        <div class="bg-secondary-50 p-4 rounded-xl border border-secondary-100">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="font-bold text-secondary-900 text-base mb-1">Order Dibuat (Menunggu Kapal)</h4>
                                    <p class="text-sm text-secondary-600">Order telah dikonfirmasi dan menunggu jadwal keberangkatan kapal di Pelabuhan Selat Lampa.</p>
                                </div>
                                <span class="px-2 py-1 bg-white border border-secondary-200 text-secondary-600 text-[10px] font-bold uppercase rounded">Sistem</span>
                            </div>
                        </div>
                    </div>

                    {{-- Timeline Item 2: Berangkat --}}
                    <div class="relative">
                        <div class="absolute -left-[25px] sm:-left-[33px] top-1 w-4 h-4 rounded-full bg-primary-500 ring-4 ring-white"></div>
                        <p class="text-sm text-secondary-500 mb-1">25 Okt 2023, 14:00 WIB</p>
                        <div class="bg-secondary-50 p-4 rounded-xl border border-secondary-100">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="font-bold text-secondary-900 text-base mb-1">Proses Pengiriman Laut</h4>
                                    <p class="text-sm text-secondary-600">Barang telah dimuat ke KM. Sabuk Nusantara 80 dan berlayar menuju Pelabuhan Batu Ampar.</p>
                                </div>
                                <span class="px-2 py-1 bg-white border border-secondary-200 text-primary-600 text-[10px] font-bold uppercase rounded">OPR-L01</span>
                            </div>
                        </div>
                    </div>

                    {{-- Timeline Item 3: Tiba (Pending) --}}
                    <div class="relative">
                        <div class="absolute -left-[25px] sm:-left-[33px] top-1 w-4 h-4 rounded-full bg-white border-2 border-secondary-300 ring-4 ring-white"></div>
                        <div class="opacity-50">
                            <h4 class="font-bold text-secondary-400 text-base mb-1">Tiba di Pelabuhan Tujuan</h4>
                            <p class="text-sm text-secondary-400">Menunggu kapal bersandar di Pelabuhan Batu Ampar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-secondary-100 shadow-sm">
                <h3 class="text-sm font-bold text-secondary-400 uppercase tracking-wider mb-4">Informasi Tambahan</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-secondary-500 mb-1">Operator Kapal</p>
                        <p class="text-sm font-semibold text-secondary-900">KM. Sabuk Nusantara 80</p>
                    </div>
                    <div>
                        <p class="text-xs text-secondary-500 mb-1">Estimasi Tiba</p>
                        <p class="text-sm font-semibold text-secondary-900">27 Okt 2023</p>
                    </div>
                    <div class="p-3 bg-warning-50 rounded-lg border border-warning-100">
                        <p class="text-xs text-warning-800 flex items-center gap-1.5 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Catatan Khusus
                        </p>
                        <p class="text-xs text-warning-700 mt-1">Barang membutuhkan es (Cold Storage). Pastikan suhu terjaga selama pelayaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(in_array(request('role', 'staff'), ['operator', 'superadmin']))
{{-- Modal Update Status (Khusus Operator) --}}
<x-modal id="modal-update-status" title="Update Status Pengiriman" maxWidth="max-w-md">
    <form class="space-y-5" data-demo-form>
        <x-form-input name="waktu" label="Waktu Update" type="datetime-local" value="2023-10-25T14:00" required />
        
        <x-form-input type="select" name="kode_status_delivery" label="Pilih Status Baru" :options="['ST-02' => 'Proses Pengiriman Laut', 'ST-03' => 'Tiba di Pelabuhan Tujuan']" required />
        
        <x-form-input type="textarea" name="catatan" label="Catatan Tambahan" rows="3" placeholder="Opsional: tambahkan keterangan..." />

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-update-status')" class="px-4 py-2 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-lg hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">Simpan Status</button>
        </div>
    </form>
</x-modal>
@endif
@endsection
