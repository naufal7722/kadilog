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
            <button onclick="exportData('CSV')" class="px-4 py-2 bg-white border border-secondary-200 text-secondary-700 rounded-xl hover:bg-secondary-50 transition-colors text-sm font-medium shadow-sm">
                Export Data
            </button>
            <button onclick="handleAdd()" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2">
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
                    <input type="text" id="search-supplier" class="w-full pl-9 pr-4 py-2 bg-white border border-secondary-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors outline-none" placeholder="Cari nama, alamat, pic...">
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <span class="text-secondary-500">Filter:</span>
                <select id="filter-pulau" class="border-secondary-200 rounded-lg text-secondary-700 bg-white py-1.5 pl-3 pr-8 text-sm focus:ring-primary-500 focus:border-primary-500 outline-none">
                    <option value="">Semua Pulau</option>
                    <option value="Batam">Batam</option>
                    <option value="Bintan">Bintan</option>
                    <option value="Karimun">Karimun</option>
                    <option value="Natuna">Natuna</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table id="table-supplier" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Kode Supplier</th>
                        <th class="px-6 py-3 font-medium">Nama UMKM</th>
                        <th class="px-6 py-3 font-medium">Nama PIC</th>
                        <th class="px-6 py-3 font-medium">Kontak PIC</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    @forelse ($suppliers as $supplier)
                        <tr class="table-row-hover supplier-row" data-alamat="{{ $supplier->alamat }}">
                            <td class="px-6 py-4 font-mono text-sm text-secondary-600">{{ $supplier->kode_supplier }}</td>
                            <td class="px-6 py-4 font-medium text-secondary-900">{{ $supplier->nama_umkm }}</td>
                            <td class="px-6 py-4 text-sm text-secondary-700">{{ $supplier->nama_pic }}</td>
                            <td class="px-6 py-4 text-sm text-secondary-700">{{ $supplier->no_hp_pic }}</td>
                            <td class="px-6 py-4 text-right space-x-1">
                                <button onclick="handleDetail('{{ $supplier->kode_supplier }}', '{{ addslashes($supplier->nama_umkm) }}', '{{ addslashes($supplier->alamat) }}', '{{ addslashes($supplier->nama_pic) }}', '{{ $supplier->no_hp_pic }}', '{{ $supplier->created_at->format('d M Y') }}')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-info-600 hover:bg-info-50 rounded-lg transition-colors" data-tooltip="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button onclick="handleEdit('{{ $supplier->kode_supplier }}', '{{ addslashes($supplier->nama_umkm) }}', '{{ addslashes($supplier->alamat) }}', '{{ addslashes($supplier->nama_pic) }}', '{{ $supplier->no_hp_pic }}')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" data-tooltip="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <button onclick="handleDelete('{{ $supplier->kode_supplier }}', '{{ addslashes($supplier->nama_umkm) }}')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors" data-tooltip="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-row">
                            <td colspan="5" class="px-6 py-10 text-center text-secondary-500">
                                Tidak ada data supplier ditemukan.
                            </td>
                        </tr>
                    @endforelse
                    <tr id="no-matching-row" style="display: none;">
                        <td colspan="5" class="px-6 py-10 text-center text-secondary-500">
                            Tidak ada data supplier cocok dengan filter.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-secondary-100 flex items-center justify-between">
            <p class="text-sm text-secondary-500">Menampilkan <span id="table-supplier-start" class="font-medium text-secondary-900">{{ count($suppliers) > 0 ? 1 : 0 }}</span> sampai <span id="table-supplier-end" class="font-medium text-secondary-900">{{ count($suppliers) }}</span> dari <span id="table-supplier-count" class="font-medium text-secondary-900">{{ count($suppliers) }}</span> data</p>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1.5 border border-secondary-200 rounded-lg text-sm font-medium text-secondary-400 bg-secondary-50 cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1.5 border border-secondary-200 rounded-lg text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 transition-colors">Selanjutnya</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Form (Tambah/Edit) --}}
<x-modal id="modal-form" title="Form Supplier" maxWidth="max-w-2xl">
    <form class="space-y-6" method="POST" action="/suppliers">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <x-form-input name="nama_umkm" label="Nama UMKM/Supplier" required />
            </div>
            <x-form-input name="nama_pic" label="Nama PIC" required />
            <x-form-input name="no_hp_pic" label="No. HP PIC" required />
            
            <div class="md:col-span-2">
                <x-form-input type="textarea" name="alamat" label="Alamat Lengkap" rows="2" required />
            </div>
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
                <h3 id="modal-detail-title" class="text-lg font-bold text-secondary-900"></h3>
                <p id="modal-detail-subtitle" class="text-sm text-secondary-500"></p>
            </div>
            <div class="ml-auto">
                <x-badge-status status="Aktif" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
            <div>
                <p class="text-secondary-500 mb-1">Nama PIC</p>
                <p id="modal-detail-pic" class="font-medium text-secondary-900"></p>
            </div>
            <div>
                <p class="text-secondary-500 mb-1">No. HP PIC</p>
                <p id="modal-detail-hp" class="font-medium text-secondary-900"></p>
            </div>
            <div class="col-span-2">
                <p class="text-secondary-500 mb-1">Alamat Lengkap</p>
                <p id="modal-detail-alamat" class="font-medium text-secondary-900"></p>
            </div>
            <div>
                <p class="text-secondary-500 mb-1">Tanggal Terdaftar</p>
                <p id="modal-detail-created" class="font-medium text-secondary-900"></p>
            </div>
        </div>

        <div class="pt-6 border-t border-secondary-100 text-center">
            <a id="modal-detail-history-btn" href="/orders" class="text-sm font-medium text-primary-600 hover:text-primary-700">Lihat Riwayat Order →</a>
        </div>
    </div>
</x-modal>

{{-- Hidden Delete Form --}}
<form id="delete-form" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast("{{ session('success') }}", 'success');
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast("{{ session('error') }}", 'error');
        });
    </script>
@endif

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($errors->all() as $error)
                showToast("{{ $error }}", 'error');
            @endforeach
        });
    </script>
@endif

@section('scripts')
<script>
    function getRoleQueryParam() {
        const params = new URLSearchParams(window.location.search);
        return params.get('role') || 'staff';
    }

    function handleAdd() {
        const form = document.querySelector('#modal-form form');
        form.reset();
        form.action = '/suppliers?role=' + getRoleQueryParam();
        document.getElementById('form-method').value = 'POST';
        document.querySelector('#modal-form h3').textContent = 'Tambah Supplier';
        
        openModal('modal-form');
    }

    function handleEdit(kode_supplier, nama_umkm, alamat, nama_pic, no_hp_pic) {
        const form = document.querySelector('#modal-form form');
        form.reset();
        form.action = '/suppliers/' + kode_supplier + '?role=' + getRoleQueryParam();
        document.getElementById('form-method').value = 'PUT';
        document.querySelector('#modal-form h3').textContent = 'Edit Supplier';
        
        populateEditModal('modal-form', {
            nama_umkm: nama_umkm,
            alamat: alamat,
            nama_pic: nama_pic,
            no_hp_pic: no_hp_pic
        });
    }

    function handleDetail(kode_supplier, nama_umkm, alamat, nama_pic, no_hp_pic, created_at) {
        document.getElementById('modal-detail-title').textContent = nama_umkm;
        document.getElementById('modal-detail-subtitle').textContent = 'ID: ' + kode_supplier;
        document.getElementById('modal-detail-pic').textContent = nama_pic;
        document.getElementById('modal-detail-hp').textContent = no_hp_pic;
        document.getElementById('modal-detail-alamat').textContent = alamat;
        document.getElementById('modal-detail-created').textContent = created_at;
        
        document.querySelector('#modal-detail .w-12').textContent = nama_umkm.charAt(0).toUpperCase();
        
        const historyBtn = document.getElementById('modal-detail-history-btn');
        if (historyBtn) {
            historyBtn.href = '/orders?role=' + getRoleQueryParam();
        }

        openModal('modal-detail');
    }

    function handleDelete(kode_supplier, nama_umkm) {
        confirmDelete(nama_umkm, function() {
            const form = document.getElementById('delete-form');
            form.action = '/suppliers/' + kode_supplier + '?role=' + getRoleQueryParam();
            form.submit();
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-supplier');
        const filterSelect = document.getElementById('filter-pulau');

        function filterTable() {
            const searchQuery = searchInput.value.toLowerCase().trim();
            const filterQuery = filterSelect.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.supplier-row');
            let visibleCount = 0;

            rows.forEach(function(row) {
                const text = row.textContent.toLowerCase();
                const alamat = (row.getAttribute('data-alamat') || '').toLowerCase();

                const matchesSearch = text.includes(searchQuery);
                const matchesFilter = filterQuery === '' || alamat.includes(filterQuery);

                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Handle no matching rows visibility
            const noMatchingRow = document.getElementById('no-matching-row');
            if (noMatchingRow) {
                noMatchingRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
            }

            const startEl = document.getElementById('table-supplier-start');
            const endEl = document.getElementById('table-supplier-end');
            const countEl = document.getElementById('table-supplier-count');

            if (startEl) startEl.textContent = visibleCount > 0 ? 1 : 0;
            if (endEl) endEl.textContent = visibleCount;
            if (countEl) countEl.textContent = visibleCount;
        }

        if (searchInput) searchInput.addEventListener('input', filterTable);
        if (filterSelect) filterSelect.addEventListener('change', filterTable);
    });
</script>
@endsection
@endsection
