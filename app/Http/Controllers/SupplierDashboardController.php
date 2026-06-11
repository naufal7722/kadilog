<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Carbon\Carbon;

class SupplierDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $supplier = $user->supplier;

        if (!$supplier) {
            // Jika user tidak punya profil supplier
            return redirect('/')->with('error', 'Profil supplier tidak ditemukan.');
        }

        $orders = Order::with(['detailOrders' => function($query) {
            $query->latest('created_at');
        }, 'detailOrders.statusDelivery', 'detailOrders.rute.pelabuhanAsal', 'detailOrders.rute.pelabuhanTujuan'])
        ->where('kode_supplier', $supplier->kode_supplier)
        ->get();

        $totalOrder = $orders->count();
        
        $sedangDikirim = 0;
        $selesaiBulanIni = 0;
        $activeShipments = [];

        $now = Carbon::now();

        foreach ($orders as $order) {
            $latestDetail = $order->detailOrders->first();
            
            if ($latestDetail) {
                $statusName = strtolower($latestDetail->statusDelivery->nama_status_delivery ?? '');
                
                if ($statusName !== 'selesai' && $statusName !== 'menunggu') {
                    $sedangDikirim++;
                    $activeShipments[] = $order;
                }

                if ($statusName === 'selesai' && $latestDetail->updated_at->month === $now->month && $latestDetail->updated_at->year === $now->year) {
                    $selesaiBulanIni++;
                }
            }
        }

        return view('dashboard.supplier', [
            'role' => 'supplier',
            'pageTitle' => 'Dashboard',
            'supplier' => $supplier,
            'totalOrder' => $totalOrder,
            'sedangDikirim' => $sedangDikirim,
            'selesaiBulanIni' => $selesaiBulanIni,
            'activeShipments' => collect($activeShipments)->take(4) // Ambil 4 teratas untuk dashboard
        ]);
    }
}
