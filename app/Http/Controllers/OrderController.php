<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Rute;
use App\Models\Operator;
use App\Models\StatusDelivery;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role', 'staff');
        
        $query = Order::with(['supplier', 'konsumen', 'detailOrders.statusDelivery', 'pelabuhanAwal', 'pelabuhanTujuan']);
        
        // Filter based on role demo parameter
        if ($role === 'supplier' && auth()->check()) {
            $query->where('kode_supplier', auth()->user()->kode_supplier);
        } elseif ($role === 'operator' && auth()->check()) {
            $query->whereHas('detailOrders', function ($q) {
                $q->where('kode_operator', auth()->user()->kode_operator);
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $pelabuhanAwalOptions = [];
        $pelabuhanTujuanOptions = [];
        $semuaKonsumen = [];
        $semuaPelabuhan = \App\Models\Pelabuhan::all();

        if ($role === 'supplier') {
            // For demo, we use auth user's supplier or fallback to first
            $supplier = (auth()->check() && auth()->user()->supplier) 
                ? auth()->user()->supplier 
                : \App\Models\Supplier::first();

            if ($supplier && $supplier->pelabuhan) {
                $namaPulau = $supplier->pelabuhan->nama_pulau;
                
                // Pelabuhan Awal = semua pelabuhan di pulau yang sama dengan supplier
                $pelabuhanAwalOptions = $semuaPelabuhan->where('nama_pulau', $namaPulau)->values();
                
                // Pelabuhan Tujuan = semua pelabuhan di LUAR pulau supplier
                $pelabuhanTujuanOptions = $semuaPelabuhan->where('nama_pulau', '!=', $namaPulau)->values();
            }

            $semuaKonsumen = \App\Models\Konsumen::with('pelabuhan')->get();
        }

        return view('orders.index', [
            'role' => $role,
            'pageTitle' => 'Kelola Order',
            'orders' => $orders,
            'rutes' => Rute::with(['pelabuhanAsal', 'pelabuhanTujuan'])->get(),
            'operators' => Operator::all(),
            'statuses' => StatusDelivery::all(),
            'pelabuhanAwalOptions' => collect($pelabuhanAwalOptions),
            'pelabuhanTujuanOptions' => collect($pelabuhanTujuanOptions),
            'semuaKonsumen' => $semuaKonsumen,
            'semuaPelabuhan' => $semuaPelabuhan,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_konsumen' => 'required|string',
            'isi_produk' => 'required|string',
            'berat' => 'required|numeric',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'tinggi' => 'required|numeric',
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
            'kode_supplier' => auth()->user()->kode_supplier,
            'isi_produk' => $request->isi_produk,
            'berat' => $request->berat,
            'dimensi' => $request->panjang . 'x' . $request->lebar . 'x' . $request->tinggi,
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
        $order = Order::with(['supplier', 'konsumen', 'detailOrders.statusDelivery', 'detailOrders.rute.pelabuhanAsal', 'detailOrders.rute.pelabuhanTujuan', 'detailOrders.operator'])
            ->where('kode_order', $kode)
            ->firstOrFail();

        $semuaPelabuhan = \App\Models\Pelabuhan::all()->keyBy('kode_pelabuhan');

        return view('orders.show', [
            'role' => $request->query('role', 'staff'),
            'pageTitle' => 'Detail Order',
            'order' => $order,
            'semuaPelabuhan' => $semuaPelabuhan,
        ]);
    }

    public function acc(Request $request)
    {
        $request->validate([
            'kode_order' => 'required|string|exists:orders,kode_order',
            'kode_supplier' => 'required|string',
            'kode_operator' => 'required|string|exists:operators,kode_operator',
            'kode_status_delivery' => 'required|string|exists:status_deliveries,kode_status_delivery',
        ]);

        $order = Order::where('kode_order', $request->kode_order)->firstOrFail();

        $rute = \App\Models\Rute::where('kode_pelabuhan_asal', $order->pengiriman_awal)
                    ->where('kode_pelabuhan_tujuan', $order->pengiriman_tujuan)
                    ->first();

        if (!$rute) {
            return redirect()->back()->with('error', 'Rute dari pelabuhan asal ke pelabuhan tujuan tidak ditemukan. Mohon tambahkan di menu Kelola Rute terlebih dahulu.');
        }

        $detailOrder = \App\Models\DetailOrder::create([
            'kode_detail_order' => 'DO-' . date('Ymd') . '-' . rand(1000, 9999),
            'kode_supplier' => $request->kode_supplier,
            'kode_order' => $request->kode_order,
            'kode_rute' => $rute->kode_rute,
            'total_jarak' => $rute->jarak, // Fetch from rute automatically
            'kode_status_delivery' => $request->kode_status_delivery,
            'kode_operator' => $request->kode_operator,
            'koordinat' => null, // Optional for now
        ]);

        \App\Models\TrackingHistory::create([
            'kode_detail_order' => $detailOrder->kode_detail_order,
            'kode_status_delivery' => $request->kode_status_delivery,
            'catatan' => 'Status awal ditetapkan oleh Staff',
        ]);

        return redirect('/orders?role=' . $request->query('role', 'staff'))->with('success', 'Order berhasil di-ACC dan Operator telah di-assign!');
    }

    public function update(Request $request, string $kode)
    {
        if (auth()->user()->role !== 'supplier') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $order = Order::with('detailOrders')->where('kode_order', $kode)->firstOrFail();

        if ($order->kode_supplier !== auth()->user()->kode_supplier) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit order ini.');
        }

        if ($order->detailOrders && $order->detailOrders->count() > 0) {
            return redirect()->back()->with('error', 'Order tidak dapat diedit karena sudah diproses (di-ACC).');
        }

        $request->validate([
            'kode_konsumen' => 'required|string',
            'isi_produk' => 'required|string',
            'berat' => 'required|numeric',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'tinggi' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'kemasan' => 'required|string',
            'es' => 'required|string',
            'pengiriman_awal' => 'required|string',
            'pengiriman_tujuan' => 'required|string',
        ]);

        $order->update([
            'isi_produk' => $request->isi_produk,
            'berat' => $request->berat,
            'dimensi' => $request->panjang . 'x' . $request->lebar . 'x' . $request->tinggi,
            'deskripsi' => $request->deskripsi,
            'kemasan' => $request->kemasan,
            'es' => $request->es === 'iya' ? true : false,
            'pengiriman_awal' => $request->pengiriman_awal,
            'pengiriman_tujuan' => $request->pengiriman_tujuan,
            'kode_konsumen' => $request->kode_konsumen,
        ]);

        return redirect()->back()->with('success', 'Order berhasil diperbarui!');
    }

    public function destroy(string $kode)
    {
        if (auth()->user()->role !== 'supplier') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $order = Order::with('detailOrders')->where('kode_order', $kode)->firstOrFail();

        if ($order->kode_supplier !== auth()->user()->kode_supplier) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus order ini.');
        }

        if ($order->detailOrders && $order->detailOrders->count() > 0) {
            return redirect()->back()->with('error', 'Order tidak dapat dihapus karena sudah diproses (di-ACC).');
        }

        $order->update(['is_cancelled' => true]);

        return redirect()->back()->with('success', 'Order berhasil dibatalkan!');
    }
}
