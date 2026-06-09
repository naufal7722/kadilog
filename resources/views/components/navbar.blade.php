@props(['role' => 'staff', 'pageTitle' => 'Dashboard'])

@php
$roleLabels = [
    'superadmin' => 'Super Admin',
    'staff' => 'Staff',
    'supplier' => 'Supplier',
    'operator' => 'Operator',
];

$roleNames = [
    'superadmin' => 'Admin Utama',
    'staff' => 'Ahmad Fauzi',
    'supplier' => 'PT. Maju Sejahtera',
    'operator' => 'Budi Santoso',
];

$notifications = [
    ['text' => 'Order baru #ORD-2024-089 telah dibuat', 'time' => '5 menit lalu', 'unread' => true],
    ['text' => 'Status pengiriman #TRK-001 diperbarui', 'time' => '15 menit lalu', 'unread' => true],
    ['text' => 'Supplier baru terdaftar: CV. Bahari', 'time' => '1 jam lalu', 'unread' => false],
];
@endphp

<header class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-secondary-200/60">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4">
            <button id="sidebar-toggle" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl text-secondary-500 hover:text-secondary-700 hover:bg-secondary-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div>
                <h1 class="text-lg font-semibold text-secondary-900">{{ $pageTitle }}</h1>
            </div>
        </div>

        {{-- Right: Actions --}}
        <div class="flex items-center gap-2">
            {{-- Role Switcher (Demo) --}}
            <div class="relative hidden sm:block">
                <button data-dropdown-toggle="role-switcher" class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-primary-700 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors border border-primary-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/></svg>
                    <span>Demo: {{ $roleLabels[$role] ?? 'Staff' }}</span>
                </button>
                <div id="role-switcher" class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-secondary-200 py-1 z-50">
                    <p class="px-3 py-2 text-[10px] uppercase tracking-wider text-secondary-400 font-semibold">Ganti Role</p>
                    @foreach (['superadmin' => 'Super Admin', 'staff' => 'Staff', 'supplier' => 'Supplier', 'operator' => 'Operator'] as $r => $label)
                        <a href="/dashboard/{{ $r }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ $role === $r ? 'text-primary-600 bg-primary-50 font-medium' : 'text-secondary-600 hover:bg-secondary-50' }} transition-colors">
                            @if($role === $r)
                                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @else
                                <span class="w-4"></span>
                            @endif
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="relative">
                <button id="notif-bell" class="relative flex items-center justify-center w-10 h-10 rounded-xl text-secondary-500 hover:text-secondary-700 hover:bg-secondary-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-danger-500 rounded-full border-2 border-white animate-pulse-soft"></span>
                </button>
                <div id="notif-dropdown" class="dropdown-menu hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-secondary-200 z-50">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-secondary-100">
                        <h3 class="text-sm font-semibold text-secondary-900">Notifikasi</h3>
                        <span class="text-xs text-primary-600 font-medium px-2 py-0.5 bg-primary-50 rounded-full">2 baru</span>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        @foreach ($notifications as $notif)
                            <div class="px-4 py-3 hover:bg-secondary-50 transition-colors border-b border-secondary-50 {{ $notif['unread'] ? 'bg-primary-50/30' : '' }}">
                                <p class="text-sm text-secondary-700">{{ $notif['text'] }}</p>
                                <p class="text-xs text-secondary-400 mt-1">{{ $notif['time'] }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-4 py-2.5 border-t border-secondary-100">
                        <a href="#" class="text-xs font-medium text-primary-600 hover:text-primary-700 transition-colors">Lihat semua notifikasi →</a>
                    </div>
                </div>
            </div>

            {{-- Profile Dropdown --}}
            <div class="relative">
                <button data-dropdown-toggle="profile-dropdown" class="flex items-center gap-3 pl-3 pr-2 py-1.5 rounded-xl hover:bg-secondary-50 transition-colors">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-medium text-secondary-900 leading-tight">{{ $roleNames[$role] ?? 'User' }}</p>
                        <p class="text-[11px] text-secondary-400">{{ $roleLabels[$role] ?? 'Staff' }}</p>
                    </div>
                    <div class="w-9 h-9 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center text-white text-sm font-semibold shadow-md">
                        {{ strtoupper(substr($roleNames[$role] ?? 'U', 0, 1)) }}
                    </div>
                </button>
                <div id="profile-dropdown" class="dropdown-menu hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-secondary-200 py-1 z-50">
                    <div class="px-4 py-3 border-b border-secondary-100">
                        <p class="text-sm font-medium text-secondary-900">{{ $roleNames[$role] ?? 'User' }}</p>
                        <p class="text-xs text-secondary-400">{{ $role }}@kasalog.id</p>
                    </div>
                    <a href="/profile?role={{ $role }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-secondary-600 hover:bg-secondary-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>
                    <hr class="my-1 border-secondary-100">
                    <a href="/login" class="flex items-center gap-2 px-4 py-2.5 text-sm text-danger-600 hover:bg-danger-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
