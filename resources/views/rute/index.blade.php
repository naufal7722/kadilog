@extends('layouts.app')

@section('title', 'Kelola Rute & Peta Logistik')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Master Data'], ['label' => 'Rute Laut & Map']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Jaringan Rute Laut</h2>
            <p class="text-secondary-500 mt-1">Pemetaan visual dan pendataan rute pelayaran antar pelabuhan.</p>
        </div>
        @if(in_array(request('role', 'staff'), ['staff', 'superadmin']))
        <button onclick="openModal('modal-form')" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Rute Baru
        </button>
        @endif
    </div>

    {{-- Map Visualization Area --}}
    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden flex flex-col relative h-[400px]">
        {{-- Map Background (Mock) --}}
        <div class="absolute inset-0 bg-blue-50">
            {{-- Grid Pattern --}}
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PGRlZnM+PHBhdHRlcm4gaWQ9ImEiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTTAgNDBoNDBWMEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0wIDQwaDQwVjBIMHoiIGZpbGw9Im5vbmUiLz48cGF0aCBkPSJNMCAuNWg0MG0tNDAgMzlINDIwIiBzdHJva2U9IiNiZmRiZmUiLz48cGF0aCBkPSJNLjUgMHY0MG0zOS00MFY0MCIgc3Ryb2tlPSIjYmZkYmZlIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2EpIi8+PC9zdmc+')] opacity-60"></div>
            
            {{-- SVG Map Mockup --}}
            <svg class="absolute inset-0 w-full h-full" preserveAspectRatio="none">
                {{-- Rute Batam -> Natuna --}}
                <path d="M 20% 70% Q 50% 30% 80% 20%" fill="none" stroke="#3b82f6" stroke-width="3" stroke-dasharray="8 6" class="animate-pulse" />
                {{-- Rute Batam -> Bintan --}}
                <path d="M 20% 70% Q 30% 80% 40% 65%" fill="none" stroke="#0ea5e9" stroke-width="3" stroke-dasharray="8 6" />
                {{-- Rute Bintan -> Natuna --}}
                <path d="M 40% 65% Q 60% 40% 80% 20%" fill="none" stroke="#0ea5e9" stroke-width="3" stroke-dasharray="8 6" />
            </svg>

            {{-- Titik Pelabuhan (Node) --}}
            {{-- Batam --}}
            <div class="absolute top-[70%] left-[20%] -translate-x-1/2 -translate-y-1/2 flex flex-col items-center group cursor-pointer">
                <div class="w-4 h-4 bg-primary-600 rounded-full border-2 border-white shadow-[0_0_0_4px_rgba(37,99,235,0.2)]"></div>
                <div class="mt-2 px-2 py-1 bg-white rounded text-xs font-bold shadow-sm border border-secondary-100 opacity-80 group-hover:opacity-100 transition-opacity">Batam (P-BTM1)</div>
            </div>

            {{-- Bintan --}}
            <div class="absolute top-[65%] left-[40%] -translate-x-1/2 -translate-y-1/2 flex flex-col items-center group cursor-pointer">
                <div class="w-4 h-4 bg-primary-600 rounded-full border-2 border-white shadow-[0_0_0_4px_rgba(37,99,235,0.2)]"></div>
                <div class="mt-2 px-2 py-1 bg-white rounded text-xs font-bold shadow-sm border border-secondary-100 opacity-80 group-hover:opacity-100 transition-opacity">Bintan (P-BTN1)</div>
            </div>

            {{-- Natuna --}}
            <div class="absolute top-[20%] left-[80%] -translate-x-1/2 -translate-y-1/2 flex flex-col items-center group cursor-pointer">
                <div class="w-4 h-4 bg-primary-600 rounded-full border-2 border-white shadow-[0_0_0_4px_rgba(37,99,235,0.2)]"></div>
                <div class="mt-2 px-2 py-1 bg-white rounded text-xs font-bold shadow-sm border border-secondary-100 opacity-80 group-hover:opacity-100 transition-opacity">Natuna (P-NTN1)</div>
            </div>
            
            {{-- Overlay Tools --}}
            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur p-3 rounded-xl border border-secondary-100 shadow-sm">
                <h4 class="text-xs font-bold text-secondary-900 uppercase tracking-wider mb-2">Legend</h4>
                <div class="flex flex-col gap-2 text-xs text-secondary-700">
                    <div class="flex items-center gap-2"><div class="w-3 h-3 bg-primary-600 rounded-full"></div> Pelabuhan</div>
                    <div class="flex items-center gap-2"><div class="w-4 border-b-2 border-dashed border-primary-500"></div> Rute Aktif</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Table Section --}}
    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden flex flex-col">
        <div class="p-4 border-b border-secondary-100 bg-secondary-50/50 flex justify-between items-center">
            <h3 class="font-bold text-secondary-900">Daftar Rute Pelayaran</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Kode Rute</th>
                        <th class="px-6 py-3 font-medium">Pelabuhan (Asal → Tujuan)</th>
                        <th class="px-6 py-3 font-medium">Jarak Tempuh</th>
                        @if(in_array(request('role', 'staff'), ['staff', 'superadmin']))
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-600">RT-001</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-medium text-secondary-900">P-BTM1</span>
                                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                <span class="font-medium text-secondary-900">P-NTN1</span>
                            </div>
                            <p class="text-xs text-secondary-500">Batam → Natuna</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-secondary-700">300 Nautical Miles</td>
                        @if(in_array(request('role', 'staff'), ['staff', 'superadmin']))
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleEdit('RT-001', 'P-BTM1', 'P-NTN1', '300 Nautical Miles')" class="text-primary-600 hover:text-primary-800 text-sm font-medium mr-3">Edit</button>
                            <button class="text-danger-600 hover:text-danger-800 text-sm font-medium">Hapus</button>
                        </td>
                        @endif
                    </tr>
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-600">RT-002</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-medium text-secondary-900">P-BTM1</span>
                                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                <span class="font-medium text-secondary-900">P-BTN1</span>
                            </div>
                            <p class="text-xs text-secondary-500">Batam → Bintan</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-secondary-700">45 Nautical Miles</td>
                        @if(in_array(request('role', 'staff'), ['staff', 'superadmin']))
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleEdit('RT-002', 'P-BTM1', 'P-BTN1', '45 Nautical Miles')" class="text-primary-600 hover:text-primary-800 text-sm font-medium mr-3">Edit</button>
                            <button class="text-danger-600 hover:text-danger-800 text-sm font-medium">Hapus</button>
                        </td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(in_array(request('role', 'staff'), ['staff', 'superadmin']))
<x-modal id="modal-form" title="Form Rute" maxWidth="max-w-md">
    <form class="space-y-5" data-demo-form>
        <x-form-input name="kode_rute" label="Kode Rute" placeholder="Misal: RT-001" required />
        
        <div class="p-4 bg-primary-50 border border-primary-100 rounded-xl space-y-4">
            <h4 class="text-xs font-bold uppercase tracking-wider text-primary-800">Koneksi Pelabuhan</h4>
            {{-- Menggunakan dropdown dummy untuk mengilustrasikan relasi kode_pelabuhan asal & tujuan --}}
            <x-form-input type="select" name="kode_pelabuhan_asal" label="Pelabuhan Asal" :options="['P-BTM1' => 'P-BTM1 (Batam)', 'P-BTN1' => 'P-BTN1 (Bintan)', 'P-NTN1' => 'P-NTN1 (Natuna)']" required />
            <div class="flex justify-center -my-3 relative z-10">
                <div class="w-8 h-8 bg-white border border-primary-200 rounded-full flex items-center justify-center text-primary-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                </div>
            </div>
            <x-form-input type="select" name="kode_pelabuhan_tujuan" label="Pelabuhan Tujuan" :options="['P-NTN1' => 'P-NTN1 (Natuna)', 'P-BTN1' => 'P-BTN1 (Bintan)', 'P-BTM1' => 'P-BTM1 (Batam)']" required />
        </div>
        
        <x-form-input name="jarak" label="Jarak Tempuh" placeholder="Misal: 300 Nautical Miles" required />

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-form')" class="px-4 py-2 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-lg hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">Simpan di Peta</button>
        </div>
    </form>
</x-modal>
@endif

<script>
    function handleEdit(kode_rute, kode_pelabuhan_asal, kode_pelabuhan_tujuan, jarak) {
        document.querySelector('#modal-form h3').textContent = 'Edit Rute';
        populateEditModal('modal-form', { kode_rute, kode_pelabuhan_asal, kode_pelabuhan_tujuan, jarak });
    }
</script>
@endsection
