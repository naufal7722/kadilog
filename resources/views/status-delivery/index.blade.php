@extends('layouts.app')

@section('title', 'Manajemen Status Delivery')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Superadmin'], ['label' => 'Status Delivery']]" />
@endsection

@section('content')
<div class="space-y-6">
    {{-- Flash Messages --}}
    @if (session('success'))
        <div id="flash-success" class="flex items-center gap-3 px-4 py-3 rounded-xl border-l-4 border-success-500 bg-success-50 text-success-700 text-sm font-medium animate-fade-in">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="flex-1">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="opacity-60 hover:opacity-100 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div id="flash-error" class="flex items-center gap-3 px-4 py-3 rounded-xl border-l-4 border-danger-500 bg-danger-50 text-danger-700 text-sm font-medium animate-fade-in">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="flex-1">{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="opacity-60 hover:opacity-100 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="flex items-start gap-3 px-4 py-3 rounded-xl border-l-4 border-warning-500 bg-warning-50 text-warning-700 text-sm animate-fade-in">
            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            <div>
                <p class="font-medium mb-1">Terdapat kesalahan pada input:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Manajemen Status Delivery</h2>
            <p class="text-secondary-500 mt-1">Master data status pengiriman yang digunakan di sistem tracking.</p>
        </div>
        <button onclick="openAddModal()" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Status
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="status-table">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Kode Status</th>
                        <th class="px-6 py-3 font-medium">Nama Status Delivery</th>
                        <th class="px-6 py-3 font-medium">Deskripsi</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    @forelse ($statuses as $status)
                        <tr class="table-row-hover">
                            <td class="px-6 py-4 font-mono text-sm text-secondary-500">{{ $status->kode_status_delivery }}</td>
                            <td class="px-6 py-4 font-medium text-secondary-900">{{ $status->nama_status_delivery }}</td>
                            <td class="px-6 py-4 text-sm text-secondary-600">{{ $status->deskripsi ?? '-' }}</td>
                            <td class="px-6 py-4 text-right space-x-1">
                                <button onclick="openEditModal('{{ $status->kode_status_delivery }}', '{{ addslashes($status->nama_status_delivery) }}', '{{ addslashes($status->deskripsi) }}')"
                                        class="text-primary-600 hover:text-primary-800 text-sm font-medium mr-2">
                                    Edit
                                </button>
                                <button onclick="handleDelete('{{ $status->kode_status_delivery }}', '{{ addslashes($status->nama_status_delivery) }}')"
                                        class="text-danger-500 hover:text-danger-700 text-sm font-medium">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                    </div>
                                    <p class="text-secondary-500 text-sm">Belum ada data status delivery.</p>
                                    <button onclick="openAddModal()" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                        + Tambah Status Pertama
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<x-modal id="modal-add" title="Tambah Status Delivery" maxWidth="max-w-md">
    <form action="{{ route('status-delivery.store') }}" method="POST" class="space-y-5">
        @csrf
        <x-form-input name="kode_status_delivery" label="Kode Status" placeholder="Misal: ST-01" required />
        <x-form-input name="nama_status_delivery" label="Nama Status Delivery" placeholder="Misal: Tiba di Pelabuhan Tujuan" required />
        <x-form-input type="textarea" name="deskripsi" label="Deskripsi" placeholder="Keterangan lengkap mengenai status ini" rows="3" />

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-add')" class="px-4 py-2 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-lg hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">Simpan</button>
        </div>
    </form>
</x-modal>

{{-- Modal Edit --}}
<x-modal id="modal-edit" title="Edit Status Delivery" maxWidth="max-w-md">
    <form id="form-edit" method="POST" class="space-y-5">
        @csrf
        @method('PUT')
        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-secondary-700">Kode Status</label>
            <input type="text" id="edit-kode" class="w-full px-3.5 py-2.5 bg-secondary-50 border border-secondary-300 rounded-xl text-sm text-secondary-500 outline-none cursor-not-allowed" readonly />
        </div>
        <x-form-input name="nama_status_delivery" label="Nama Status Delivery" placeholder="Misal: Tiba di Pelabuhan Tujuan" required />
        <x-form-input type="textarea" name="deskripsi" label="Deskripsi" placeholder="Keterangan lengkap mengenai status ini" rows="3" />

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-edit')" class="px-4 py-2 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-lg hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">Perbarui</button>
        </div>
    </form>
</x-modal>

{{-- Hidden Delete Form --}}
<form id="form-delete" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    function openAddModal() {
        openModal('modal-add');
    }

    function openEditModal(kode, nama, deskripsi) {
        const form = document.getElementById('form-edit');
        form.action = '/status-delivery/' + encodeURIComponent(kode);

        document.getElementById('edit-kode').value = kode;

        const modal = document.getElementById('modal-edit');
        const namaInput = modal.querySelector('[name="nama_status_delivery"]');
        const deskripsiInput = modal.querySelector('[name="deskripsi"]');
        if (namaInput) namaInput.value = nama;
        if (deskripsiInput) deskripsiInput.value = deskripsi;

        openModal('modal-edit');
    }

    function handleDelete(kode, nama) {
        confirmDelete(nama, function() {
            const form = document.getElementById('form-delete');
            form.action = '/status-delivery/' + encodeURIComponent(kode);
            form.submit();
        });
    }

    // Auto-dismiss flash messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        ['flash-success', 'flash-error'].forEach(function(id) {
            const el = document.getElementById(id);
            if (el) {
                setTimeout(function() {
                    el.style.transition = 'opacity 0.3s ease-out';
                    el.style.opacity = '0';
                    setTimeout(function() { el.remove(); }, 300);
                }, 5000);
            }
        });
    });
</script>
@endsection
