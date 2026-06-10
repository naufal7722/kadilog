<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Rute;
use App\Models\Operator;
use App\Models\StatusDelivery;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role', 'staff');
        
        $query = Order::with(['supplier', 'konsumen', 'detailOrders.statusDelivery']);
        
        // Filter based on role demo parameter
        if ($role === 'supplier') {
            // Mock auth check or just filter by SUP-001 for demo
            $query->where('kode_supplier', 'SUP-001');
        } elseif ($role === 'operator') {
            // Mock auth check for operator demo
            // Assume the logged in operator is OPR-L01
            $query->whereHas('detailOrders', function ($q) {
                $q->where('kode_operator', 'OPR-L01');
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return view('orders.index', [
            'role' => $role,
            'pageTitle' => 'Kelola Order',
            'orders' => $orders,
            'rutes' => Rute::with('pelabuhan')->get(),
            'operators' => Operator::all(),
            'statuses' => StatusDelivery::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_konsumen' => 'required|string',
            'isi_produk' => 'required|string',
            'berat' => 'required|numeric',
            'dimensi' => 'required|string',
            'deskripsi' => 'nullable|string',
            'kemasan' => 'required|string',
            'es' => 'required|string',
            'pengiriman_awal' => 'required|string',
            'pengiriman_tujuan' => 'required|string',
        ]);

        // Generate kode order (simple format)
        $kode_order = 'ORD-' . date('Ymd') . '-' . rand(100, 999);

        Order::create([
            'kode_order' => $kode_order,
            'kode_supplier' => 'SUP-001', // Hardcoded for demo as supplier makes it
            'isi_produk' => $request->isi_produk,
            'berat' => $request->berat,
            'dimensi' => $request->dimensi,
            'deskripsi' => $request->deskripsi,
            'kemasan' => $request->kemasan,
            'es' => $request->es === 'iya' ? true : false,
            'pengiriman_awal' => $request->pengiriman_awal,
            'pengiriman_tujuan' => $request->pengiriman_tujuan,
            'kode_konsumen' => $request->kode_konsumen,
        ]);

        return redirect('/orders?role=' . $request->query('role', 'supplier'))->with('success', 'Order berhasil dibuat!');
    }

    public function show(Request $request, string $kode)
    {
        $order = Order::with(['supplier', 'konsumen', 'detailOrders.statusDelivery', 'detailOrders.rute.pelabuhan', 'detailOrders.operator'])
            ->where('kode_order', $kode)
            ->firstOrFail();

        return view('orders.show', [
            'role' => $request->query('role', 'staff'),
            'pageTitle' => 'Detail Order',
            'order' => $order,
        ]);
    }

    public function acc(Request $request)
    {
        $request->validate([
            'kode_order' => 'required|string|exists:orders,kode_order',
            'kode_supplier' => 'required|string',
            'kode_rute' => 'required|string|exists:rutes,kode_rute',
            'kode_operator' => 'required|string|exists:operators,kode_operator',
            'kode_status_delivery' => 'required|string|exists:status_deliveries,kode_status_delivery',
        ]);

        $rute = Rute::where('kode_rute', $request->kode_rute)->firstOrFail();

        \App\Models\DetailOrder::create([
            'kode_detail_order' => 'DO-' . date('Ymd') . '-' . rand(1000, 9999),
            'kode_supplier' => $request->kode_supplier,
            'kode_order' => $request->kode_order,
            'kode_rute' => $request->kode_rute,
            'total_jarak' => $rute->jarak, // Fetch from rute automatically
            'kode_status_delivery' => $request->kode_status_delivery,
            'kode_operator' => $request->kode_operator,
            'koordinat' => null, // Optional for now
        ]);

        return redirect('/orders?role=' . $request->query('role', 'staff'))->with('success', 'Order berhasil di-ACC dan Operator telah di-assign!');
    }
}
