@extends('layouts.app')

@section('title', 'Kelola Operator')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Master Data'], ['label' => 'Operator Kapal']]" />
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Operator Transportasi Laut</h2>
            <p class="text-secondary-500 mt-1">Manajemen armada kapal yang melayani pengiriman antarpulau.</p>
        </div>
        <button onclick="openModal('modal-form')" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Operator
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table id="table-operator" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Kode Operator</th>
                        <th class="px-6 py-3 font-medium">Nama Operator / Kapal</th>
                        <th class="px-6 py-3 font-medium">No. HP</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-600">OPR-L01</td>
                        <td class="px-6 py-4 font-medium text-secondary-900">KM. Sabuk Nusantara 80</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">0811-2233-4455</td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleEdit('OPR-L01', 'KM. Sabuk Nusantara 80', '0811-2233-4455')" class="p-2 text-secondary-400 hover:text-primary-600 bg-white hover:bg-primary-50 rounded-lg transition-colors border border-transparent hover:border-primary-100 shadow-sm">
                                Edit
                            </button>
                        </td>
                    </tr>
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-600">OPR-L02</td>
                        <td class="px-6 py-4 font-medium text-secondary-900">Kapal RoRo Bahari</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">0812-9988-7766</td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleEdit('OPR-L02', 'Kapal RoRo Bahari', '0812-9988-7766')" class="p-2 text-secondary-400 hover:text-primary-600 bg-white hover:bg-primary-50 rounded-lg transition-colors border border-transparent hover:border-primary-100 shadow-sm">
                                Edit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<x-modal id="modal-form" title="Form Operator" maxWidth="max-w-md">
    <form class="space-y-6" data-demo-form>
        <x-form-input name="kode_operator" label="Kode Operator" placeholder="Misal: OPR-L01" required />
        <x-form-input name="nama_operator" label="Nama Operator / Kapal" required />
        <x-form-input type="text" name="no_hp" label="No. Handphone" required />

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-form')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm">Simpan Data</button>
        </div>
    </form>
</x-modal>

@section('scripts')
<script>
    function handleEdit(kode_operator, nama_operator, no_hp) {
        document.querySelector('#modal-form h3').textContent = 'Edit Operator';
        populateEditModal('modal-form', {
            kode_operator, nama_operator, no_hp
        });
    }
</script>
@endsection
@endsection
