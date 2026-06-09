@extends('layouts.app')

@section('title', 'Kelola Rute & Peta Logistik')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Master Data'], ['label' => 'Rute Laut & Map']]" />
@endsection

@section('content')
{{-- Leaflet CSS CDN --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-secondary-900">Jaringan Rute Laut</h2>
            <p class="text-secondary-500 mt-1">Pemetaan visual geografis dan pendataan rute pelayaran antar pelabuhan.</p>
        </div>
        @if(in_array($role, ['staff', 'superadmin']))
        <div class="flex items-center gap-2">
            <button onclick="handleAdd()" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm flex items-center gap-2 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Rute Baru
            </button>
        </div>
        @endif
    </div>

    {{-- Map Visualization Area using Leaflet --}}
    <div class="bg-white rounded-2xl border border-secondary-100 shadow-sm overflow-hidden flex flex-col relative">
        <div id="map" class="z-0 h-[450px] w-full bg-blue-50/50"></div>
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
                        @if(in_array($role, ['staff', 'superadmin']))
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100">
                    @forelse ($rutes as $rute)
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 font-mono text-sm text-secondary-600">RT-{{ str_pad($rute->kode_rute, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-medium text-secondary-900">Batam</span>
                                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                <span class="font-medium text-secondary-900">{{ $rute->pelabuhan->nama_pelabuhan ?? 'Tidak Diketahui' }}</span>
                            </div>
                            <p class="text-xs text-secondary-500">Batam → {{ $rute->pelabuhan->nama_pulau ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-secondary-700">{{ $rute->jarak }} Nautical Miles</td>
                        @if(in_array($role, ['staff', 'superadmin']))
                        <td class="px-6 py-4 text-right space-x-1">
                            <button onclick="handleEdit('{{ $rute->kode_rute }}', '{{ $rute->kode_pelabuhan }}', '{{ $rute->jarak }}')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" data-tooltip="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button onclick="handleDelete('{{ $rute->kode_rute }}', 'Batam -> {{ addslashes($rute->pelabuhan->nama_pelabuhan ?? 'Pelabuhan') }}')" class="inline-flex items-center justify-center p-2 text-secondary-400 hover:text-danger-600 hover:bg-danger-50 rounded-lg transition-colors" data-tooltip="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ in_array($role, ['staff', 'superadmin']) ? 4 : 3 }}" class="px-6 py-10 text-center text-secondary-500">
                            Tidak ada rute yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(in_array($role, ['staff', 'superadmin']))
{{-- Modal Form (Tambah/Edit) --}}
<x-modal id="modal-form" title="Form Rute" maxWidth="max-w-md">
    <form class="space-y-5" method="POST" action="/rute">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">

        <div class="p-4 bg-primary-50 border border-primary-100 rounded-xl space-y-4">
            <h4 class="text-xs font-bold uppercase tracking-wider text-primary-800">Koneksi Pelabuhan</h4>
            
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-secondary-500 uppercase">Pelabuhan Asal</label>
                <div class="w-full px-3 py-2 bg-secondary-100 text-secondary-600 rounded-lg text-sm font-medium">
                    Batam (Pusat Distribusi)
                </div>
            </div>

            <div class="flex justify-center -my-2 relative z-10">
                <div class="w-8 h-8 bg-white border border-primary-200 rounded-full flex items-center justify-center text-primary-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                </div>
            </div>

            <x-form-input type="select" name="kode_pelabuhan" label="Pelabuhan Tujuan" 
                :options="$pelabuhans->pluck('nama_pelabuhan', 'kode_pelabuhan')->toArray()" required />
        </div>
        
        <x-form-input name="jarak" label="Jarak Tempuh (Nautical Miles)" placeholder="Misal: 300" required />

        <div class="flex justify-end gap-3 pt-6 border-t border-secondary-100">
            <button type="button" onclick="closeModal('modal-form')" class="px-4 py-2 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-lg hover:bg-secondary-200 transition-colors">Batal</button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">Simpan di Peta</button>
        </div>
    </form>
</x-modal>

{{-- Hidden Delete Form --}}
<form id="delete-form" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

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
{{-- Leaflet JS CDN --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    const allPelabuhans = @json($pelabuhans);
    const activeRutes = @json($rutes);

    function getRoleQueryParam() {
        const params = new URLSearchParams(window.location.search);
        return params.get('role') || 'staff';
    }

    function handleAdd() {
        const form = document.querySelector('#modal-form form');
        form.reset();
        form.action = '/rute?role=' + getRoleQueryParam();
        document.getElementById('form-method').value = 'POST';
        document.querySelector('#modal-form h3').textContent = 'Tambah Rute';
        
        openModal('modal-form');
    }

    // Populate and open edit modal
    function handleEdit(kode, kode_pelabuhan, jarak) {
        const form = document.querySelector('#modal-form form');
        form.reset();
        form.action = '/rute/' + kode + '?role=' + getRoleQueryParam();
        document.getElementById('form-method').value = 'PUT';
        document.querySelector('#modal-form h3').textContent = 'Edit Rute';
        
        populateEditModal('modal-form', {
            kode_pelabuhan, jarak
        });
        
        openModal('modal-form');
    }

    function handleDelete(id, name) {
        confirmDelete(name, function() {
            const form = document.getElementById('delete-form');
            form.action = '/rute/' + id + '?role=' + getRoleQueryParam();
            form.submit();
        });
    }

    // Leaflet Map Initialization and Rendering
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof L === 'undefined') {
            return; // Fallback if Leaflet library failed to load
        }

        const mapElement = document.getElementById('map');
        if (!mapElement) return;

        // Coordinates Parser helper
        function parseCoords(coordString) {
            if (!coordString) return null;
            const parts = coordString.split(',').map(part => parseFloat(part.trim()));
            if (parts.length === 2 && !isNaN(parts[0]) && !isNaN(parts[1])) {
                return parts;
            }
            return null;
        }

        // Find Batam base coordinates from DB, fallback to Batu Ampar coords if none
        let batamCoords = [1.1615, 104.0042];
        const batamPort = allPelabuhans.find(p => p.nama_pulau.toLowerCase() === 'batam');
        if (batamPort && batamPort.koordinat) {
            const parsed = parseCoords(batamPort.koordinat);
            if (parsed) batamCoords = parsed;
        }

        // Initialize Map centered near the Riau Archipelago (lat: ~2.4, lng: ~106.0)
        // Zoom level 7 fits Batam, Karimun, Bintan, and Natuna in one view
        const map = L.map('map').setView([2.4, 106.0], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Marker Icons
        // Custom Blue Marker HTML matching the app design system
        const portIconHtml = `<div class="w-4 h-4 bg-primary-600 rounded-full border-2 border-white shadow-[0_0_0_4px_rgba(37,99,235,0.25)] hover:scale-125 transition-transform duration-200"></div>`;
        const portIcon = L.divIcon({
            className: 'custom-port-marker',
            html: portIconHtml,
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });

        // Custom Green Marker HTML for Batam Base
        const baseIconHtml = `<div class="w-4 h-4 bg-emerald-600 rounded-full border-2 border-white shadow-[0_0_0_4px_rgba(16,185,129,0.25)] hover:scale-125 transition-transform duration-200"></div>`;
        const baseIcon = L.divIcon({
            className: 'custom-base-marker',
            html: baseIconHtml,
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });

        const markersGroup = L.layerGroup().addTo(map);
        const portCoordsMap = {};

        // Draw Markers for all Pelabuhans
        allPelabuhans.forEach(p => {
            const coords = parseCoords(p.koordinat);
            if (!coords) return;

            portCoordsMap[p.kode_pelabuhan] = coords;

            const isBatam = p.nama_pulau.toLowerCase() === 'batam';
            const marker = L.marker(coords, {
                icon: isBatam ? baseIcon : portIcon
            }).addTo(markersGroup);

            const popupContent = `
                <div class="font-sans p-1">
                    <b class="text-sm text-secondary-900 block">${p.nama_pelabuhan}</b>
                    <span class="text-xs text-secondary-500 block mb-1">Pulau: ${p.nama_pulau} | Kode: ${p.kode_pelabuhan}</span>
                    <hr class="my-1 border-secondary-100">
                    <span class="text-xs text-secondary-700 block"><b>Gudang:</b> ${p.nama_gudang}</span>
                    <span class="text-[10px] text-secondary-400 font-mono block mt-1">Koord: ${coords[0]}, ${coords[1]}</span>
                </div>
            `;
            marker.bindPopup(popupContent);
        });

        // Draw Polylines for Active Rutes
        activeRutes.forEach(r => {
            if (!r.kode_pelabuhan) return;

            const destCoords = portCoordsMap[r.kode_pelabuhan];
            if (!destCoords) return;

            // 1. Draw Border/Outline Polyline (Thick Dark Blue)
            const borderPolyline = L.polyline([batamCoords, destCoords], {
                color: '#1e3a8a', // Dark blue
                weight: 7,
                lineCap: 'round',
                lineJoin: 'round',
                opacity: 0.9
            }).addTo(map);

            // 2. Draw Inner Polyline (Lighter Blue)
            const innerPolyline = L.polyline([batamCoords, destCoords], {
                color: '#3b82f6', // Bright blue
                weight: 4,
                lineCap: 'round',
                lineJoin: 'round',
                opacity: 1
            }).addTo(map);

            const routePopup = `
                <div class="font-sans p-1 text-xs">
                    <b class="text-primary-700 block mb-0.5">Rute Pelayaran Aktif</b>
                    <span class="text-secondary-800 font-semibold block">Batam → ${r.pelabuhan ? r.pelabuhan.nama_pelabuhan : 'Tujuan'}</span>
                    <span class="text-secondary-500 block mt-1"><b>Jarak:</b> ${r.jarak} Nautical Miles</span>
                </div>
            `;
            innerPolyline.bindPopup(routePopup);
            borderPolyline.bindPopup(routePopup);

            // 3. Highlight line on hover
            const highlightLine = function(e) {
                innerPolyline.setStyle({ color: '#60a5fa' }); // Lighter blue on hover
            };
            const resetLine = function(e) {
                innerPolyline.setStyle({ color: '#3b82f6' }); // Reset inner blue
            };
            innerPolyline.on('mouseover', highlightLine);
            innerPolyline.on('mouseout', resetLine);
            borderPolyline.on('mouseover', highlightLine);
            borderPolyline.on('mouseout', resetLine);

            // 4. Calculate Midpoint for Tooltip
            const midLat = (batamCoords[0] + destCoords[0]) / 2;
            const midLng = (batamCoords[1] + destCoords[1]) / 2;
            
            // Generate random time estimation for realism (e.g. 1.2 hrs per 10 nm)
            const estimatedHours = Math.max(1, Math.round((r.jarak / 15) * 10) / 10);

            // 5. Add Tooltip floating label
            const labelHtml = `
                <div class="flex items-center gap-1.5 font-sans font-medium text-[11px] text-secondary-800 whitespace-nowrap">
                    <svg class="w-3 h-3 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                    <span>${estimatedHours} Jam</span>
                    <span class="text-secondary-300 mx-0.5">|</span>
                    <span class="text-primary-600">${r.jarak} NM</span>
                </div>
            `;
            
            L.tooltip({
                permanent: true,
                direction: 'center',
                className: 'bg-white/95 backdrop-blur shadow-sm border border-secondary-200 rounded px-2 py-1',
                opacity: 1
            })
            .setLatLng([midLat, midLng])
            .setContent(labelHtml)
            .addTo(map);
        });

        // Invalidate map size to prevent gray boxes on load
        setTimeout(() => {
            map.invalidateSize();
        }, 150);
    });
</script>
@endsection
