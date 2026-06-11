<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role', 'staff');
        $search = $request->query('search');
        
        $query = Order::with(['supplier', 'konsumen', 'detailOrders' => function($q) {
            $q->orderBy('created_at', 'desc');
        }, 'detailOrders.histories.statusDelivery', 'detailOrders.statusDelivery', 'detailOrders.operator']);
        
        // Filter based on search (nomor resi/order)
        if ($search) {
            $query->where('kode_order', 'like', '%' . $search . '%');
        }

        // Filter based on role authentication
        if ($role === 'supplier' && auth()->check()) {
            $query->where('kode_supplier', auth()->user()->kode_supplier);
        } elseif ($role === 'operator' && auth()->check()) {
            $query->whereHas('detailOrders', function ($q) {
                $q->where('kode_operator', auth()->user()->kode_operator);
            });
        }

        // Only get active orders (has detail order, but latest status is not 'selesai')
        $query->whereHas('detailOrders', function($q) {
            // At least one detail order exists
        });

        $allOrders = $query->orderBy('created_at', 'desc')->get();
        
        $activeDeliveries = [];
        $completedDeliveries = [];
        
        foreach ($allOrders as $order) {
            $latestDetail = $order->detailOrders->first();
            if ($latestDetail) {
                $statusName = strtolower($latestDetail->statusDelivery->nama_status_delivery ?? '');
                $order->latestStatus = $latestDetail->statusDelivery->nama_status_delivery ?? 'Dalam Proses';
                $order->latestUpdatedAt = $latestDetail->updated_at;
                
                if ($statusName !== 'selesai') {
                    $activeDeliveries[] = $order;
                } else {
                    $completedDeliveries[] = $order;
                }
            }
        }

        return view('tracking.index', [
            'role' => $role,
            'pageTitle' => 'Tracking Delivery',
            'activeDeliveries' => $activeDeliveries,
            'completedDeliveries' => $completedDeliveries,
            'search' => $search
        ]);
    }

    public function show(Request $request, string $kode)
    {
        $order = Order::with(['supplier', 'konsumen', 'detailOrders.histories.statusDelivery', 'detailOrders.operator', 'detailOrders.rute.pelabuhanAsal', 'detailOrders.rute.pelabuhanTujuan', 'pelabuhanAwal', 'pelabuhanTujuan'])
            ->where('kode_order', $kode)
            ->firstOrFail();

        return view('tracking.show', [
            'role' => $request->query('role', 'staff'),
            'pageTitle' => 'Detail Tracking',
            'order' => $order,
        ]);
    }
}
