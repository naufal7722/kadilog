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
        <button onclick="handleAdd()" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Operator
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden flex flex-col">
        {{-- Toolbar --}}
        <div class="p-4 border-b border-secondary-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-secondary-50/50">
            <div class="flex items-center gap-2">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-secondary-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" id="search-operator" class="w-full pl-9 pr-4 py-2 bg-white border border-secondary-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors outline-none" placeholder="Cari nama, no hp...">
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
            <table id="table-operator" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-secondary-50 text-secondary-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Kode Operator</th>
                        <th class="px-6 py-3 font-medium">Nama Operator / Kapal</th>
                        <th class="px-6 py-3 font-medium">Basis Pelabuhan</th>
                        <th class="px-6 py-3 font-medium">No. HP</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    @forelse ($operators as $operator)
                    <tr class="table-row-hover operator-row" data-alamat="{{ $operator->pelabuhan->nama_pulau ?? '' }}">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-600">{{ $operator->kode_operator }}</td>
                        <td class="px-6 py-4 font-medium text-secondary-900">{{ $operator->nama_operator }}</td>
                        <td class="px-6 py-4 text-sm text-secondary-700">
                            @if($operator->pelabuhan)
                                <span class="font-medium">{{ $operator->pelabuhan->nama_pelabuhan }}</span>
                                <span class="text-xs text-secondary-500 block">Pulau {{ $operator->pelabuhan->nama_pulau }}</span>
                            @else
                                <span class="text-secondary-400 italic">Belum Ditentukan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-secondary-700">{{ $operator->no_hp }}</td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleDetail('{{ $operator->kode_operator }}', '{{ addslashes($operator->nama_operator) }}', '{{ addslashes($operator->no_hp) }}', '{{ $operator->created_at->format('d M Y') }}', '{{ addslashes($operator->pelabuhan->nama_pelabuhan ?? 'Belum Ditentukan') }}')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-info-600 hover:bg-info-50 rounded-lg transition-colors" data-tooltip="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button onclick="handleEdit('{{ $operator->kode_operator }}', '{{ addslashes($operator->nama_operator) }}', '{{ addslashes($operator->no_hp) }}', '{{ $operator->kode_pelabuhan }}')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" data-tooltip="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button onclick="handleDelete('{{ $operator->kode_operator }}', '{{ addslashes($operator->nama_operator) }}')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors" data-tooltip="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="4" class="px-6 py-10 text-center text-secondary-500">
                            Tidak ada data operator.
                        </td>
                    </tr>
                    @endforelse
                    <tr id="no-matching-row" style="display: none;">
                        <td colspan="4" class="px-6 py-10 text-center text-secondary-500">
                            Tidak ada data operator cocok dengan filter.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination / Count --}}
        <div class="px-6 py-4 border-t border-secondary-100 flex items-center justify-between">
            <p class="text-sm text-secondary-500">Menampilkan <span id="table-operator-start" class="font-medium text-secondary-900">{{ count($operators) > 0 ? 1 : 0 }}</span> sampai <span id="table-operator-end" class="font-medium text-secondary-900">{{ count($operators) }}</span> dari <span id="table-operator-count" class="font-medium text-secondary-900">{{ count($operators) }}</span> data</p>
        </div>
    </div>
</div>

<x-modal id="modal-form" title="Form Operator" maxWidth="max-w-md">
    <form class="space-y-6" method="POST" action="/operators">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">

        <x-form-input name="nama_operator" label="Nama Operator / Kapal" required />
        <x-form-input type="text" name="no_hp" label="No. Handphone" required />

        <div class="space-y-1.5">
            <label for="kode_pelabuhan" class="block text-sm font-medium text-secondary-700">
                Basis Pelabuhan Penugasan <span class="text-danger-500">*</span>
            </label>
            <select name="kode_pelabuhan" id="kode_pelabuhan" required
                    class="w-full px-3.5 py-2.5 bg-white border border-secondary-300 rounded-xl text-sm text-secondary-700 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors outline-none">
                <option value="">Pilih Pelabuhan...</option>
                @foreach ($pelabuhans as $pulau => $ports)
                    <optgroup label="Pulau {{ $pulau }}">
                        @foreach ($ports as $port)
                            <option value="{{ $port->kode_pelabuhan }}">{{ $port->nama_pelabuhan }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-form')" class="px-5 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm">Simpan Data</button>
        </div>
    </form>
</x-modal>

{{-- Modal Detail --}}
<x-modal id="modal-detail" title="Detail Operator" maxWidth="max-w-md">
    <div class="space-y-6">
        <div class="flex items-center gap-4 pb-4 border-b border-secondary-100">
            <div class="w-12 h-12 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center text-xl font-bold">
                O
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
                <p class="text-secondary-500 mb-1">No. Handphone</p>
                <p id="modal-detail-hp" class="font-medium text-secondary-900"></p>
            </div>
            <div>
                <p class="text-secondary-500 mb-1">Basis Pelabuhan</p>
                <p id="modal-detail-pelabuhan" class="font-medium text-secondary-900"></p>
            </div>
            <div>
                <p class="text-secondary-500 mb-1">Tanggal Terdaftar</p>
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

@section('scripts')
<script>
    function getRoleQueryParam() {
        const params = new URLSearchParams(window.location.search);
        return params.get('role') || 'staff';
    }

    function handleAdd() {
        const form = document.querySelector('#modal-form form');
        form.reset();
        form.action = '/operators?role=' + getRoleQueryParam();
        document.getElementById('form-method').value = 'POST';
        document.querySelector('#modal-form h3').textContent = 'Tambah Operator';
        
        openModal('modal-form');
    }

    function handleEdit(kode_operator, nama_operator, no_hp, kode_pelabuhan) {
        const form = document.querySelector('#modal-form form');
        form.reset();
        form.action = '/operators/' + kode_operator + '?role=' + getRoleQueryParam();
        document.getElementById('form-method').value = 'PUT';
        document.querySelector('#modal-form h3').textContent = 'Edit Operator';
        
        populateEditModal('modal-form', {
            nama_operator, no_hp, kode_pelabuhan
        });

        openModal('modal-form');
    }

    function handleDetail(kode, nama, hp, created, pelabuhan) {
        document.getElementById('modal-detail-title').textContent = nama;
        document.getElementById('modal-detail-subtitle').textContent = kode;
        document.getElementById('modal-detail-hp').textContent = hp;
        document.getElementById('modal-detail-pelabuhan').textContent = pelabuhan;
        document.getElementById('modal-detail-created').textContent = created;
        openModal('modal-detail');
    }

    function handleDelete(id, name) {
        confirmDelete(name, function() {
            const form = document.getElementById('delete-form');
            form.action = '/operators/' + id + '?role=' + getRoleQueryParam();
            form.submit();
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-operator');
        const filterSelect = document.getElementById('filter-pulau');

        function filterTable() {
            const searchQuery = searchInput.value.toLowerCase().trim();
            const filterQuery = filterSelect.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.operator-row');
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

            const noMatchingRow = document.getElementById('no-matching-row');
            if (noMatchingRow) {
                noMatchingRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
            }

            const startEl = document.getElementById('table-operator-start');
            const endEl = document.getElementById('table-operator-end');
            const countEl = document.getElementById('table-operator-count');

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
