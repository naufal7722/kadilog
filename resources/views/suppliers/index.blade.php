@extends('layouts.app')

@section('title', 'Kelola Supplier')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Master Data'], ['label' => 'Supplier']]" />
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Kelola Supplier</h2>
            <p class="text-secondary-500 mt-1">Manajemen data master supplier/pengirim barang.</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 bg-white border border-secondary-200 text-secondary-700 rounded-xl hover:bg-secondary-50 transition-colors text-sm font-medium shadow-sm">
                Export Data
            </button>
            <button onclick="openModal('modal-form')" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Supplier
            </button>
        </div>
    </div>

    {{-- Data Table Section --}}
    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden flex flex-col">
        {{-- Toolbar --}}
        <div class="p-4 border-b border-secondary-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-secondary-50/50">
            <div class="flex items-center gap-2">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-secondary-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" data-table-search="table-supplier" class="w-full pl-9 pr-4 py-2 bg-white border border-secondary-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors outline-none" placeholder="Cari nama, email...">
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <span class="text-secondary-500">Filter:</span>
                <select class="border-secondary-200 rounded-lg text-secondary-700 bg-white py-1.5 pl-3 pr-8 text-sm focus:ring-primary-500 focus:border-primary-500 outline-none">
                    <option>Semua Pulau</option>
                    <option>Batam</option>
                    <option>Bintan</option>
                    <option>Karimun</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table id="table-supplier" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Nama Supplier</th>
                        <th class="px-6 py-3 font-medium">Kontak</th>
                        <th class="px-6 py-3 font-medium">Pulau Asal</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    {{-- Row 1 --}}
                    <tr class="table-row-hover">
                        <td class="px-6 py-4">
                            <p class="font-medium text-secondary-900">PT. Maju Sejahtera</p>
                            <p class="text-xs text-secondary-500 mt-0.5">SUP-001</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-secondary-700">budi@majusejahtera.com</p>
                            <p class="text-xs text-secondary-500 mt-0.5">0812-3456-7890</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-secondary-700">Batam</td>
                        <td class="px-6 py-4">
                            <x-badge-status status="Aktif" />
                        </td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="openModal('modal-detail')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-info-600 hover:bg-info-50 rounded-lg transition-colors" data-tooltip="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button onclick="handleEdit('PT. Maju Sejahtera', 'budi@majusejahtera.com', '0812-3456-7890', 'Batam', 'Batam Center', '1')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" data-tooltip="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button onclick="confirmDelete('PT. Maju Sejahtera')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors" data-tooltip="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                    {{-- Row 2 --}}
                    <tr class="table-row-hover">
                        <td class="px-6 py-4">
                            <p class="font-medium text-secondary-900">CV. Bahari Karya</p>
                            <p class="text-xs text-secondary-500 mt-0.5">SUP-002</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-secondary-700">admin@baharikarya.id</p>
                            <p class="text-xs text-secondary-500 mt-0.5">0852-1122-3344</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-secondary-700">Bintan</td>
                        <td class="px-6 py-4">
                            <x-badge-status status="Aktif" />
                        </td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="openModal('modal-detail')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-info-600 hover:bg-info-50 rounded-lg transition-colors" data-tooltip="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button onclick="handleEdit('CV. Bahari Karya', 'admin@baharikarya.id', '0852-1122-3344', 'Bintan', 'Tanjung Uban', '1')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" data-tooltip="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button onclick="confirmDelete('CV. Bahari Karya')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors" data-tooltip="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-secondary-100 flex items-center justify-between">
            <p class="text-sm text-secondary-500">Menampilkan <span class="font-medium text-secondary-900">1</span> sampai <span class="font-medium text-secondary-900">2</span> dari <span id="table-supplier-count" class="font-medium text-secondary-900">2</span> data</p>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1.5 border border-secondary-200 rounded-lg text-sm font-medium text-secondary-400 bg-secondary-50 cursor-not-allowed">Sebeumnya</button>
                <button class="px-3 py-1.5 border border-secondary-200 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 transition-colors">Selanjutnya</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Form (Tambah/Edit) --}}
<x-modal id="modal-form" title="Form Supplier" maxWidth="max-w-2xl">
    <form class="space-y-6" data-demo-form>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <x-form-input name="nama" label="Nama Perusahaan/Supplier" required />
            </div>
            <x-form-input type="email" name="email" label="Email" required />
            <x-form-input type="text" name="telepon" label="No. Telepon/WA" required />
            
            <div class="md:col-span-2">
                <x-form-input type="textarea" name="alamat" label="Alamat Lengkap" rows="2" required />
            </div>

            <x-form-input type="select" name="pulau" label="Pulau Asal" :options="['Batam' => 'Batam', 'Bintan' => 'Bintan', 'Karimun' => 'Karimun']" required />
            <x-form-input type="select" name="status" label="Status" :options="['1' => 'Aktif', '0' => 'Nonaktif']" />
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-form')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">
                Batal
            </button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm">
                Simpan Data
            </button>
        </div>
    </form>
</x-modal>

{{-- Modal Detail --}}
<x-modal id="modal-detail" title="Detail Supplier" maxWidth="max-w-lg">
    <div class="space-y-6">
        <div class="flex items-center gap-4 pb-4 border-b border-secondary-100">
            <div class="w-12 h-12 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center text-xl font-bold">
                P
            </div>
            <div>
                <h3 class="text-lg font-bold text-secondary-900">PT. Maju Sejahtera</h3>
                <p class="text-sm text-secondary-500">ID: SUP-001</p>
            </div>
            <div class="ml-auto">
                <x-badge-status status="Aktif" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
            <div>
                <p class="text-secondary-500 mb-1">Email</p>
                <p class="font-medium text-secondary-900">budi@majusejahtera.com</p>
            </div>
            <div>
                <p class="text-secondary-500 mb-1">No. Telepon</p>
                <p class="font-medium text-secondary-900">0812-3456-7890</p>
            </div>
            <div class="col-span-2">
                <p class="text-secondary-500 mb-1">Alamat</p>
                <p class="font-medium text-secondary-900">Batam Center, Ruko Greenland Blok B No. 12</p>
            </div>
            <div>
                <p class="text-secondary-500 mb-1">Pulau Asal</p>
                <p class="font-medium text-secondary-900">Batam</p>
            </div>
            <div>
                <p class="text-secondary-500 mb-1">Tanggal Bergabung</p>
                <p class="font-medium text-secondary-900">12 Jan 2024</p>
            </div>
        </div>

        <div class="pt-6 border-t border-secondary-100 text-center">
            <a href="/orders?role=staff" class="text-sm font-medium text-primary-600 hover:text-primary-700">Lihat Riwayat Order →</a>
        </div>
    </div>
</x-modal>

@section('scripts')
<script>
    function handleEdit(nama, email, telepon, pulau, alamat, status) {
        // Reset form
        document.querySelector('#modal-form form').reset();
        
        // Mengubah judul modal
        document.querySelector('#modal-form h3').textContent = 'Edit Supplier';
        
        // Memasukkan data ke form
        populateEditModal('modal-form', {
            nama: nama,
            email: email,
            telepon: telepon,
            alamat: alamat,
            pulau: pulau,
            status: status
        });
    }
</script>
@endsection
@endsection
