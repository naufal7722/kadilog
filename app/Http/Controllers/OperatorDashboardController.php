<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailOrder;
use Carbon\Carbon;

class OperatorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $operator = $user->operator;

        if (!$operator) {
            return redirect('/')->with('error', 'Profil operator tidak ditemukan.');
        }

        // Get all detail orders assigned to this operator
        $tasks = DetailOrder::with(['order', 'statusDelivery', 'rute.pelabuhanAsal', 'rute.pelabuhanTujuan'])
            ->where('kode_operator', $operator->kode_operator)
            ->get();

        $menungguPickup = 0;
        $dalamPengiriman = 0;
        $selesaiHariIni = 0;
        $jarakBulanIni = 0;
        
        $activeDeliveries = [];
        $now = Carbon::now();

        foreach ($tasks as $task) {
            $statusName = strtolower($task->statusDelivery->nama_status_delivery ?? '');

            // Menunggu Pickup count
            if (str_contains($statusName, 'menunggu') || str_contains($statusName, 'persiapan')) {
                $menungguPickup++;
                $activeDeliveries[] = $task;
            } 
            // Dalam Pengiriman count
            elseif ($statusName !== 'selesai' && $statusName !== '') {
                $dalamPengiriman++;
                $activeDeliveries[] = $task;
            }

            // Selesai Hari Ini count
            if ($statusName === 'selesai' && $task->updated_at->isToday()) {
                $selesaiHariIni++;
            }

            // Jarak Tempuh (Bulan Ini) count
            if ($statusName === 'selesai' && $task->updated_at->month === $now->month && $task->updated_at->year === $now->year) {
                $jarakBulanIni += (float) $task->total_jarak;
            }
        }

        return view('dashboard.operator', [
            'role' => 'operator',
            'pageTitle' => 'Dashboard',
            'operator' => $operator,
            'menungguPickup' => $menungguPickup,
            'dalamPengiriman' => $dalamPengiriman,
            'selesaiHariIni' => $selesaiHariIni,
            'jarakBulanIni' => $jarakBulanIni,
            'activeDeliveries' => collect($activeDeliveries)->sortByDesc('created_at')->take(5)
        ]);
    }

    public function updateStatus(Request $request)
    {
        $user = Auth::user();
        $operator = $user->operator;

        if (!$operator) {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'kode_detail_order' => 'required|exists:detail_orders,kode_detail_order',
            'kode_status_delivery' => 'required|exists:status_deliveries,kode_status_delivery',
            'catatan' => 'nullable|string',
        ]);

        $detailOrder = DetailOrder::where('kode_detail_order', $request->kode_detail_order)
            ->where('kode_operator', $operator->kode_operator)
            ->firstOrFail();

        // Insert history
        \App\Models\TrackingHistory::create([
            'kode_detail_order' => $detailOrder->kode_detail_order,
            'kode_status_delivery' => $request->kode_status_delivery,
            'catatan' => $request->catatan,
        ]);

        // Update latest status on detail_orders
        $detailOrder->update([
            'kode_status_delivery' => $request->kode_status_delivery,
        ]);

        return redirect()->back()->with('success', 'Status pengiriman berhasil diperbarui!');
    }
}
