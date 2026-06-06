@props(['role' => 'staff'])

@php
$currentPath = request()->path();

$menuItems = [
    'superadmin' => [
        ['label' => 'Dashboard', 'href' => '/dashboard/superadmin', 'icon' => 'dashboard', 'match' => 'dashboard'],
        ['label' => 'Supplier', 'href' => '/suppliers?role=superadmin', 'icon' => 'supplier', 'match' => 'suppliers'],
        ['label' => 'Konsumen', 'href' => '/konsumen?role=superadmin', 'icon' => 'konsumen', 'match' => 'konsumen'],
        ['label' => 'Operator', 'href' => '/operators?role=superadmin', 'icon' => 'operator', 'match' => 'operators'],
        ['label' => 'Pelabuhan', 'href' => '/pelabuhan?role=superadmin', 'icon' => 'pelabuhan', 'match' => 'pelabuhan'],
        ['label' => 'Rute', 'href' => '/rute?role=superadmin', 'icon' => 'rute', 'match' => 'rute'],
        ['label' => 'Order', 'href' => '/orders?role=superadmin', 'icon' => 'order', 'match' => 'orders'],
        ['label' => 'Tracking', 'href' => '/tracking?role=superadmin', 'icon' => 'tracking', 'match' => 'tracking'],
        ['label' => 'Status Delivery', 'href' => '/status-delivery', 'icon' => 'status', 'match' => 'status-delivery'],
    ],
    'staff' => [
        ['label' => 'Dashboard', 'href' => '/dashboard/staff', 'icon' => 'dashboard', 'match' => 'dashboard'],
        ['label' => 'Supplier', 'href' => '/suppliers?role=staff', 'icon' => 'supplier', 'match' => 'suppliers'],
        ['label' => 'Konsumen', 'href' => '/konsumen?role=staff', 'icon' => 'konsumen', 'match' => 'konsumen'],
        ['label' => 'Operator', 'href' => '/operators?role=staff', 'icon' => 'operator', 'match' => 'operators'],
        ['label' => 'Pelabuhan', 'href' => '/pelabuhan?role=staff', 'icon' => 'pelabuhan', 'match' => 'pelabuhan'],
        ['label' => 'Rute', 'href' => '/rute?role=staff', 'icon' => 'rute', 'match' => 'rute'],
        ['label' => 'Order', 'href' => '/orders?role=staff', 'icon' => 'order', 'match' => 'orders'],
    ],
    'supplier' => [
        ['label' => 'Dashboard', 'href' => '/dashboard/supplier', 'icon' => 'dashboard', 'match' => 'dashboard'],
        ['label' => 'Order Saya', 'href' => '/orders?role=supplier', 'icon' => 'order', 'match' => 'orders'],
        ['label' => 'Tracking', 'href' => '/tracking?role=supplier', 'icon' => 'tracking', 'match' => 'tracking'],
    ],
    'operator' => [
        ['label' => 'Dashboard', 'href' => '/dashboard/operator', 'icon' => 'dashboard', 'match' => 'dashboard'],
        ['label' => 'Rute Saya', 'href' => '/rute?role=operator', 'icon' => 'rute', 'match' => 'rute'],
        ['label' => 'Update Status', 'href' => '/tracking?role=operator', 'icon' => 'tracking', 'match' => 'tracking'],
    ],
];

$items = $menuItems[$role] ?? $menuItems['staff'];
@endphp

<aside id="sidebar" class="fixed top-0 left-0 z-50 h-screen w-64 bg-secondary-900 text-white transition-all duration-300 -translate-x-full lg:translate-x-0">
    {{-- Logo Area --}}
    <div class="flex items-center justify-between h-16 px-5 border-b border-white/10">
        <a href="/dashboard/{{ $role }}" class="flex items-center gap-3">
            <div class="w-9 h-9 bg-gradient-to-br from-primary-400 to-accent-500 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <span class="sidebar-text text-lg font-bold tracking-tight">KasaLog</span>
        </a>
        <button id="sidebar-collapse" class="hidden lg:flex items-center justify-center w-7 h-7 rounded-lg hover:bg-white/10 transition-colors text-secondary-400 hover:text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
        </button>
    </div>

    {{-- Role Badge --}}
    <div class="px-5 py-3 border-b border-white/10">
        <div class="sidebar-text flex items-center gap-2 px-3 py-1.5 rounded-lg bg-primary-500/20 text-primary-300 text-xs font-medium">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span class="capitalize">{{ $role }}</span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto" style="max-height: calc(100vh - 180px);">
        <p class="sidebar-text px-3 mb-2 text-[10px] uppercase tracking-widest text-secondary-500 font-semibold">Menu Utama</p>

        @foreach ($items as $item)
            @php
                $isActive = str_contains($currentPath, $item['match']);
            @endphp
            <a href="{{ $item['href'] }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                      {{ $isActive
                          ? 'bg-primary-600/20 text-primary-300 nav-active'
                          : 'text-secondary-400 hover:text-white hover:bg-white/5' }}"
               data-tooltip="{{ $item['label'] }}">
                @switch($item['icon'])
                    @case('dashboard')
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zm10-1a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1h-4a1 1 0 01-1-1v-5z"/></svg>
                        @break
                    @case('supplier')
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        @break
                    @case('konsumen')
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        @break
                    @case('operator')
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        @break
                    @case('pelabuhan')
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                        @break
                    @case('rute')
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        @break
                    @case('order')
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        @break
                    @case('tracking')
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        @break
                    @case('status')
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        @break
                @endswitch
                <span class="sidebar-text">{{ $item['label'] }}</span>
            </a>
        @endforeach

        <hr class="my-4 border-white/10">
        <p class="sidebar-text px-3 mb-2 text-[10px] uppercase tracking-widest text-secondary-500 font-semibold">Akun</p>

        <a href="/profile?role={{ $role }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                  {{ str_contains($currentPath, 'profile') ? 'bg-primary-600/20 text-primary-300 nav-active' : 'text-secondary-400 hover:text-white hover:bg-white/5' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="sidebar-text">Profil Saya</span>
        </a>

        <a href="/login"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-secondary-400 hover:text-danger-400 hover:bg-danger-500/10 transition-all duration-200">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            <span class="sidebar-text">Keluar</span>
        </a>
    </nav>
</aside>
