@extends('layouts.app')

@section('title', 'Kelola Konsumen')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Master Data'], ['label' => 'Konsumen']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Kelola Konsumen</h2>
            <p class="text-secondary-500 mt-1">Manajemen data penerima barang di berbagai pulau.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="openModal('modal-form')" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Konsumen
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table id="table-konsumen" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Kode Konsumen</th>
                        <th class="px-6 py-3 font-medium">Nama Konsumen</th>
                        <th class="px-6 py-3 font-medium">Nama PIC</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-600">KON-001</td>
                        <td class="px-6 py-4 font-medium text-secondary-900">Fawwaz</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">Bpk. Sudirman</td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleEdit('KON-001', 'Fawwaz', 'Bpk. Sudirman')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button onclick="confirmDelete('Fawwaz')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-600">KON-002</td>
                        <td class="px-6 py-4 font-medium text-secondary-900">Arif</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">Ibu Siti Khadijah</td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button  class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-modal id="modal-form" title="Form Konsumen" maxWidth="max-w-md">
    <form class="space-y-6" data-demo-form>
        <x-form-input name="kode_konsumen" label="Kode Konsumen" placeholder="Misal: KON-001" required />
        <x-form-input name="nama_konsumen" label="Nama Konsumen / Toko" required />
        <x-form-input name="nama_pic_konsumen" label="Nama PIC Konsumen" required />

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-form')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm">Simpan Data</button>
        </div>
    </form>
</x-modal>

@section('scripts')
<script>
    function handleEdit(kode_konsumen, nama_konsumen, nama_pic_konsumen) {
        document.querySelector('#modal-form h3').textContent = 'Edit Konsumen';
        populateEditModal('modal-form', {
            kode_konsumen, nama_konsumen, nama_pic_konsumen
        });
    }
</script>
@endsection
@endsection
