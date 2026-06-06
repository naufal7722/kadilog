@extends('layouts.app')

@section('title', 'Kelola Pelabuhan')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Master Data'], ['label' => 'Pelabuhan & Gudang']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Titik Pelabuhan Transit</h2>
            <p class="text-secondary-500 mt-1">Master data pelabuhan dan titik koordinat untuk integrasi rute laut.</p>
        </div>
        <button onclick="openModal('modal-form')" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pelabuhan
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table id="table-pelabuhan" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Kode</th>
                        <th class="px-6 py-3 font-medium">Nama Pelabuhan</th>
                        <th class="px-6 py-3 font-medium">Nama Pulau</th>
                        <th class="px-6 py-3 font-medium">Nama Gudang</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-600">P-BTM1</td>
                        <td class="px-6 py-4 font-medium text-secondary-900">Pelabuhan Batu Ampar</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">Batam</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">Gudang Logistik Batam 1</td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleEdit('P-BTM1', 'Pelabuhan Batu Ampar', 'Batam', 'Gudang Logistik Batam 1', '1.1615, 104.0042')" class="text-primary-600 hover:text-primary-800 text-sm font-medium mr-3">Edit</button>
                            <button class="text-danger-600 hover:text-danger-800 text-sm font-medium">Hapus</button>
                        </td>
                    </tr>
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-600">P-NTN1</td>
                        <td class="px-6 py-4 font-medium text-secondary-900">Pelabuhan Selat Lampa</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">Natuna</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">Gudang Transit Natuna</td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleEdit('P-NTN1', 'Pelabuhan Selat Lampa', 'Natuna', 'Gudang Transit Natuna', '3.6766, 108.1256')" class="text-primary-600 hover:text-primary-800 text-sm font-medium mr-3">Edit</button>
                            <button class="text-danger-600 hover:text-danger-800 text-sm font-medium">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-modal id="modal-form" title="Form Pelabuhan" maxWidth="max-w-lg">
    <form class="space-y-5" data-demo-form>
        <div class="grid grid-cols-2 gap-4">
            <x-form-input name="kode_pelabuhan" label="Kode Pelabuhan" placeholder="Misal: P-BTM1" required />
            <x-form-input name="nama_pulau" label="Nama Pulau" placeholder="Misal: Batam" required />
        </div>
        <x-form-input name="nama_pelabuhan" label="Nama Pelabuhan" required />
        <x-form-input name="nama_gudang" label="Nama Gudang (Terhubung)" required />
        <x-form-input name="koordinat" label="Koordinat (Latitude, Longitude)" placeholder="-0.1234, 104.5678" required />

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-form')" class="px-4 py-2 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-lg hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">Simpan</button>
        </div>
    </form>
</x-modal>

<script>
    function handleEdit(kode_pelabuhan, nama_pelabuhan, nama_pulau, nama_gudang, koordinat) {
        document.querySelector('#modal-form h3').textContent = 'Edit Pelabuhan';
        populateEditModal('modal-form', { 
            kode_pelabuhan, nama_pelabuhan, nama_pulau, nama_gudang, koordinat 
        });
    }
</script>
@endsection
