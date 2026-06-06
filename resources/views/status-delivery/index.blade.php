@extends('layouts.app')

@section('title', 'Manajemen Status Delivery')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Superadmin'], ['label' => 'Status Delivery']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Manajemen Status Delivery</h2>
            <p class="text-secondary-500 mt-1">Master data status pengiriman yang digunakan di sistem tracking.</p>
        </div>
        <button onclick="openModal('modal-form')" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Status
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Kode Status</th>
                        <th class="px-6 py-3 font-medium">Nama Status Delivery</th>
                        <th class="px-6 py-3 font-medium">Deskripsi</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-500">ST-01</td>
                        <td class="px-6 py-4 font-medium text-secondary-900">Menunggu Kapal</td>
                        <td class="px-6 py-4 text-sm text-secondary-600">Order telah dibuat dan menunggu jadwal keberangkatan kapal dari pelabuhan asal.</td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleEdit('ST-01', 'Menunggu Kapal', 'Order telah dibuat dan menunggu jadwal keberangkatan kapal dari pelabuhan asal.')" class="text-primary-600 hover:text-primary-800 text-sm font-medium mr-3">Edit</button>
                        </td>
                    </tr>
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-500">ST-02</td>
                        <td class="px-6 py-4 font-medium text-secondary-900">Proses Pengiriman Laut</td>
                        <td class="px-6 py-4 text-sm text-secondary-600">Barang sedang dikirim antarpulau menggunakan kapal.</td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleEdit('ST-02', 'Proses Pengiriman Laut', 'Barang sedang dikirim antarpulau menggunakan kapal.')" class="text-primary-600 hover:text-primary-800 text-sm font-medium mr-3">Edit</button>
                        </td>
                    </tr>
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-500">ST-03</td>
                        <td class="px-6 py-4 font-medium text-secondary-900">Tiba di Pelabuhan Tujuan</td>
                        <td class="px-6 py-4 text-sm text-secondary-600">Barang telah tiba di pelabuhan tujuan dan disimpan di gudang.</td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleEdit('ST-03', 'Tiba di Pelabuhan Tujuan', 'Barang telah tiba di pelabuhan tujuan dan disimpan di gudang.')" class="text-primary-600 hover:text-primary-800 text-sm font-medium mr-3">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-modal id="modal-form" title="Form Status Delivery" maxWidth="max-w-md">
    <form class="space-y-5" data-demo-form>
        <x-form-input name="kode_status_delivery" label="Kode Status" placeholder="Misal: ST-01" required />
        <x-form-input name="nama_status_delivery" label="Nama Status Delivery" placeholder="Misal: Tiba di Pelabuhan Tujuan" required />
        <x-form-input type="textarea" name="deskripsi" label="Deskripsi" placeholder="Keterangan lengkap mengenai status ini" rows="3" required />

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-form')" class="px-4 py-2 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-lg hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">Simpan</button>
        </div>
    </form>
</x-modal>

<script>
    function handleEdit(kode_status_delivery, nama_status_delivery, deskripsi) {
        document.querySelector('#modal-form h3').textContent = 'Edit Status Delivery';
        populateEditModal('modal-form', { kode_status_delivery, nama_status_delivery, deskripsi });
    }
</script>
@endsection
