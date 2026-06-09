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
        <div class="flex items-center gap-2">
            <button onclick="handleAdd()" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pelabuhan
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden flex flex-col">
        {{-- Toolbar --}}
        <div class="p-4 border-b border-secondary-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-secondary-50/50">
            <div class="flex items-center gap-2">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-secondary-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" id="search-pelabuhan" class="w-full pl-9 pr-4 py-2 bg-white border border-secondary-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors outline-none" placeholder="Cari pelabuhan, gudang...">
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <span class="text-secondary-500">Filter:</span>
                <select id="filter-pulau" class="border-secondary-200 rounded-lg text-secondary-700 bg-white py-1.5 pl-3 pr-8 text-sm focus:ring-primary-500 focus:border-primary-500 outline-none">
                    <option value="">Semua Wilayah</option>
                    <option value="Batam">Batam</option>
                    <option value="Bintan">Bintan</option>
                    <option value="Karimun">Karimun</option>
                    <option value="Natuna">Natuna</option>
                </select>
            </div>
        </div>

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
                    @forelse ($pelabuhans as $pelabuhan)
                    <tr class="table-row-hover pelabuhan-row" data-pulau="{{ $pelabuhan->nama_pulau }}">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-600">{{ $pelabuhan->kode_pelabuhan }}</td>
                        <td class="px-6 py-4 font-medium text-secondary-900">{{ $pelabuhan->nama_pelabuhan }}</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">{{ $pelabuhan->nama_pulau }}</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">{{ $pelabuhan->nama_gudang }}</td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleDetail('{{ $pelabuhan->kode_pelabuhan }}', '{{ addslashes($pelabuhan->nama_pelabuhan) }}', '{{ addslashes($pelabuhan->nama_pulau) }}', '{{ addslashes($pelabuhan->nama_gudang) }}', '{{ addslashes($pelabuhan->koordinat) }}', '{{ $pelabuhan->created_at->format('d M Y') }}')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-info-600 hover:bg-info-50 rounded-lg transition-colors" data-tooltip="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button onclick="handleEdit('{{ $pelabuhan->kode_pelabuhan }}', '{{ addslashes($pelabuhan->nama_pelabuhan) }}', '{{ addslashes($pelabuhan->nama_pulau) }}', '{{ addslashes($pelabuhan->nama_gudang) }}', '{{ addslashes($pelabuhan->koordinat) }}')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" data-tooltip="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button onclick="handleDelete('{{ $pelabuhan->kode_pelabuhan }}', '{{ addslashes($pelabuhan->nama_pelabuhan) }}')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors" data-tooltip="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="5" class="px-6 py-10 text-center text-secondary-500">
                            Tidak ada data pelabuhan.
                        </td>
                    </tr>
                    @endforelse
                    <tr id="no-matching-row" style="display: none;">
                        <td colspan="5" class="px-6 py-10 text-center text-secondary-500">
                            Tidak ada data pelabuhan cocok dengan filter.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination / Count --}}
        <div class="px-6 py-4 border-t border-secondary-100 flex items-center justify-between">
            <p class="text-sm text-secondary-500">Menampilkan <span id="table-pelabuhan-start" class="font-medium text-secondary-900">{{ count($pelabuhans) > 0 ? 1 : 0 }}</span> sampai <span id="table-pelabuhan-end" class="font-medium text-secondary-900">{{ count($pelabuhans) }}</span> dari <span id="table-pelabuhan-count" class="font-medium text-secondary-900">{{ count($pelabuhans) }}</span> data</p>
        </div>
    </div>
</div>

{{-- Modal Form (Tambah/Edit) --}}
<x-modal id="modal-form" title="Form Pelabuhan" maxWidth="max-w-lg">
    <form class="space-y-6" method="POST" action="/pelabuhan">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">
        
        <x-form-input name="nama_pelabuhan" label="Nama Pelabuhan" required />
        <x-form-input name="nama_pulau" label="Nama Pulau (Batam, Bintan, dll)" required />
        <x-form-input name="nama_gudang" label="Nama Gudang" required />
        <x-form-input name="koordinat" label="Koordinat (Latitude, Longitude)" placeholder="-0.1234, 104.5678" />

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-form')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm">Simpan Data</button>
        </div>
    </form>
</x-modal>

{{-- Modal Detail --}}
<x-modal id="modal-detail" title="Detail Pelabuhan" maxWidth="max-w-md">
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

        <div class="grid grid-cols-1 gap-y-4 text-sm">
            <div>
                <p class="text-secondary-500 mb-1">Nama Pulau</p>
                <p id="modal-detail-pulau" class="font-medium text-secondary-900"></p>
            </div>
            <div>
                <p class="text-secondary-500 mb-1">Nama Gudang</p>
                <p id="modal-detail-gudang" class="font-medium text-secondary-900"></p>
            </div>
            <div>
                <p class="text-secondary-500 mb-1">Koordinat</p>
                <p id="modal-detail-koordinat" class="font-medium text-secondary-900"></p>
            </div>
            <div>
                <p class="text-secondary-500 mb-1">Tanggal Didaftarkan</p>
                <p id="modal-detail-created" class="font-medium text-secondary-900"></p>
            </div>
        </div>

        <div class="pt-6 border-t border-secondary-100 flex justify-end">
            <button type="button" onclick="closeModal('modal-detail')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">
                Tutup
            </button>
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

@endsection

@section('scripts')
<script>
    function getRoleQueryParam() {
        const params = new URLSearchParams(window.location.search);
        return params.get('role') || 'staff';
    }

    function handleAdd() {
        const form = document.querySelector('#modal-form form');
        form.reset();
        form.action = '/pelabuhan?role=' + getRoleQueryParam();
        document.getElementById('form-method').value = 'POST';
        document.querySelector('#modal-form h3').textContent = 'Tambah Pelabuhan';
        
        openModal('modal-form');
    }

    function handleEdit(kode, nama_pelabuhan, nama_pulau, nama_gudang, koordinat) {
        const form = document.querySelector('#modal-form form');
        form.reset();
        form.action = '/pelabuhan/' + kode + '?role=' + getRoleQueryParam();
        document.getElementById('form-method').value = 'PUT';
        document.querySelector('#modal-form h3').textContent = 'Edit Pelabuhan';
        
        populateEditModal('modal-form', {
            nama_pelabuhan, nama_pulau, nama_gudang, koordinat
        });
        
        openModal('modal-form');
    }

    function handleDetail(kode, nama, pulau, gudang, koordinat, created) {
        document.getElementById('modal-detail-title').textContent = nama;
        document.getElementById('modal-detail-subtitle').textContent = kode;
        document.getElementById('modal-detail-pulau').textContent = pulau;
        document.getElementById('modal-detail-gudang').textContent = gudang;
        document.getElementById('modal-detail-koordinat').textContent = koordinat || '-';
        document.getElementById('modal-detail-created').textContent = created;
        openModal('modal-detail');
    }

    function handleDelete(id, name) {
        confirmDelete(name, function() {
            const form = document.getElementById('delete-form');
            form.action = '/pelabuhan/' + id + '?role=' + getRoleQueryParam();
            form.submit();
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-pelabuhan');
        const filterSelect = document.getElementById('filter-pulau');

        function filterTable() {
            const searchQuery = searchInput.value.toLowerCase().trim();
            const filterQuery = filterSelect.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.pelabuhan-row');
            let visibleCount = 0;

            rows.forEach(function(row) {
                const text = row.textContent.toLowerCase();
                const pulau = (row.getAttribute('data-pulau') || '').toLowerCase();

                const matchesSearch = text.includes(searchQuery);
                const matchesFilter = filterQuery === '' || pulau.includes(filterQuery);

                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const noMatchingRow = document.getElementById('no-matching-row');
            if (noMatchingRow) {
                noMatchingRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
            }

            const startEl = document.getElementById('table-pelabuhan-start');
            const endEl = document.getElementById('table-pelabuhan-end');
            const countEl = document.getElementById('table-pelabuhan-count');

            if (startEl) startEl.textContent = visibleCount > 0 ? 1 : 0;
            if (endEl) endEl.textContent = visibleCount;
            if (countEl) countEl.textContent = visibleCount;
        }

        if (searchInput) searchInput.addEventListener('input', filterTable);
        if (filterSelect) filterSelect.addEventListener('change', filterTable);
    });
</script>
@endsection
