<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Supplier;
use App\Models\Konsumen;
use App\Models\Operator;
use App\Models\Rute;

class DashboardController extends Controller
{
    public function index(Request $request, string $role = 'staff')
    {
        $validRoles = ['superadmin', 'staff', 'supplier', 'operator'];
        $role = in_array($role, $validRoles) ? $role : 'staff';

        if ($role === 'superadmin') {
            return $this->superadminDashboard($role);
        } elseif ($role === 'staff') {
            return $this->staffDashboard($role);
        } elseif ($role === 'supplier') {
            return redirect('/dashboard/supplier');
        } elseif ($role === 'operator') {
            return redirect('/dashboard/operator');
        }

        return redirect('/');
    }

    private function superadminDashboard($role)
    {
        // Total Order Aktif (DetailOrder where status is not selesai)
        $totalOrderAktif = DetailOrder::whereHas('statusDelivery', function($q) {
            $q->where('nama_status_delivery', 'not like', '%selesai%');
        })->count();

        // Dalam Perjalanan (contains perjalanan or berangkat)
        $pengirimanAktif = DetailOrder::whereHas('statusDelivery', function($q) {
            $q->where('nama_status_delivery', 'like', '%perjalanan%')
              ->orWhere('nama_status_delivery', 'like', '%berangkat%');
        })->count();

        $totalSupplier = Supplier::count();
        $totalOperator = Operator::count();

        // Recent activities
        $recentActivities = DetailOrder::with(['order.supplier', 'statusDelivery', 'operator'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.superadmin', [
            'role' => $role,
            'pageTitle' => 'Dashboard Superadmin',
            'totalOrderAktif' => $totalOrderAktif,
            'pengirimanAktif' => $pengirimanAktif,
            'totalSupplier' => $totalSupplier,
            'totalOperator' => $totalOperator,
            'recentActivities' => $recentActivities
        ]);
    }

    private function staffDashboard($role)
    {
        // Order Perlu Diproses (Order yang belum punya detail_order atau detail_order status pending)
        $orderPending = Order::doesntHave('detailOrders')->count() + 
            DetailOrder::whereHas('statusDelivery', function($q) {
                $q->where('nama_status_delivery', 'like', '%menunggu%')
                  ->orWhere('nama_status_delivery', 'like', '%pending%');
            })->count();

        $totalKonsumen = Konsumen::count();
        $totalRute = Rute::count();
        $totalOperator = Operator::count();

        $recentOrders = Order::with(['supplier', 'konsumen'])
            ->doesntHave('detailOrders')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.staff', [
            'role' => $role,
            'pageTitle' => 'Dashboard Staff',
            'orderPending' => $orderPending,
            'totalKonsumen' => $totalKonsumen,
            'totalRute' => $totalRute,
            'totalOperator' => $totalOperator,
            'recentOrders' => $recentOrders
        ]);
    }
}
