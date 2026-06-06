@props([
    'title' => '',
    'value' => '0',
    'icon' => 'chart',
    'color' => 'primary',
    'trend' => null,
    'trendValue' => '',
    'subtitle' => '',
])

@php
$colorClasses = [
    'primary' => ['bg' => 'bg-primary-50', 'icon' => 'text-primary-600', 'ring' => 'ring-primary-100'],
    'success' => ['bg' => 'bg-success-50', 'icon' => 'text-success-600', 'ring' => 'ring-success-100'],
    'warning' => ['bg' => 'bg-warning-50', 'icon' => 'text-warning-600', 'ring' => 'ring-warning-100'],
    'danger'  => ['bg' => 'bg-danger-50', 'icon' => 'text-danger-600', 'ring' => 'ring-danger-100'],
    'info'    => ['bg' => 'bg-info-50', 'icon' => 'text-info-600', 'ring' => 'ring-info-100'],
    'accent'  => ['bg' => 'bg-accent-50', 'icon' => 'text-accent-600', 'ring' => 'ring-accent-100'],
];
$c = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

<div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-secondary-100 hover:shadow-md">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-secondary-500 mb-1">{{ $title }}</p>
            <p class="text-2xl font-bold text-secondary-900">{{ $value }}</p>
            @if ($trend || $subtitle)
                <div class="flex items-center gap-1.5 mt-2">
                    @if ($trend === 'up')
                        <span class="flex items-center gap-0.5 text-xs font-medium text-success-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            {{ $trendValue }}
                        </span>
                    @elseif ($trend === 'down')
                        <span class="flex items-center gap-0.5 text-xs font-medium text-danger-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                            {{ $trendValue }}
                        </span>
                    @endif
                    @if ($subtitle)
                        <span class="text-xs text-secondary-400">{{ $subtitle }}</span>
                    @endif
                </div>
            @endif
        </div>
        <div class="flex items-center justify-center w-12 h-12 rounded-2xl {{ $c['bg'] }} ring-1 {{ $c['ring'] }}">
            @switch($icon)
                @case('order')
                    <svg class="w-6 h-6 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    @break
                @case('supplier')
                    <svg class="w-6 h-6 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    @break
                @case('konsumen')
                    <svg class="w-6 h-6 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    @break
                @case('operator')
                    <svg class="w-6 h-6 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    @break
                @case('tracking')
                    <svg class="w-6 h-6 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    @break
                @case('pelabuhan')
                    <svg class="w-6 h-6 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                    @break
                @case('rute')
                    <svg class="w-6 h-6 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    @break
                @default
                    <svg class="w-6 h-6 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            @endswitch
        </div>
    </div>
</div>
