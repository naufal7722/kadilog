@props(['status' => ''])

@php
$statusConfig = [
    'Menunggu Pickup'              => ['color' => 'bg-secondary-100 text-secondary-700', 'dot' => 'bg-secondary-400'],
    'Dikemas'                      => ['color' => 'bg-info-50 text-info-600', 'dot' => 'bg-info-500'],
    'Dalam Perjalanan ke Gudang'   => ['color' => 'bg-primary-50 text-primary-700', 'dot' => 'bg-primary-500'],
    'Tiba di Gudang'               => ['color' => 'bg-accent-50 text-accent-600', 'dot' => 'bg-accent-500'],
    'Dalam Perjalanan ke Pelabuhan' => ['color' => 'bg-warning-50 text-warning-700', 'dot' => 'bg-warning-500'],
    'Dalam Pengiriman Antar Pulau' => ['color' => 'bg-primary-100 text-primary-800', 'dot' => 'bg-primary-600'],
    'Tiba di Pelabuhan Tujuan'     => ['color' => 'bg-accent-100 text-accent-700', 'dot' => 'bg-accent-600'],
    'Sedang Diantar ke Konsumen'   => ['color' => 'bg-success-50 text-success-700', 'dot' => 'bg-success-500'],
    'Selesai'                      => ['color' => 'bg-success-100 text-success-700', 'dot' => 'bg-success-600'],
    'Dibatalkan'                   => ['color' => 'bg-danger-50 text-danger-700', 'dot' => 'bg-danger-500'],
    'Aktif'                        => ['color' => 'bg-success-50 text-success-700', 'dot' => 'bg-success-500'],
    'Nonaktif'                     => ['color' => 'bg-secondary-100 text-secondary-600', 'dot' => 'bg-secondary-400'],
    'Pending'                      => ['color' => 'bg-warning-50 text-warning-700', 'dot' => 'bg-warning-500'],
    'Diproses'                     => ['color' => 'bg-info-50 text-info-600', 'dot' => 'bg-info-500'],
];

$config = $statusConfig[$status] ?? ['color' => 'bg-secondary-100 text-secondary-600', 'dot' => 'bg-secondary-400'];
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $config['color'] }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
    {{ $status }}
</span>
