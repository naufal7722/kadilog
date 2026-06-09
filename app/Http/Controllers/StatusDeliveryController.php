<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusDelivery;

class StatusDeliveryController extends Controller
{
    /**
     * Tampilkan halaman manajemen status delivery.
     */
    public function index()
    {
        $statuses = StatusDelivery::orderBy('kode_status_delivery')->get();

        return view('status-delivery.index', [
            'role' => 'superadmin',
            'pageTitle' => 'Manajemen Status Delivery',
            'statuses' => $statuses,
        ]);
    }

    /**
     * Simpan status delivery baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_status_delivery' => 'required|string|max:20|unique:status_deliveries,kode_status_delivery',
            'nama_status_delivery' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'kode_status_delivery.required' => 'Kode status wajib diisi.',
            'kode_status_delivery.unique' => 'Kode status sudah digunakan.',
            'kode_status_delivery.max' => 'Kode status maksimal 20 karakter.',
            'nama_status_delivery.required' => 'Nama status delivery wajib diisi.',
            'nama_status_delivery.max' => 'Nama status delivery maksimal 255 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        StatusDelivery::create($validated);

        return redirect()->route('status-delivery.index')
            ->with('success', 'Status delivery berhasil ditambahkan.');
    }

    /**
     * Update status delivery yang ada.
     */
    public function update(Request $request, string $kode)
    {
        $status = StatusDelivery::findOrFail($kode);

        $validated = $request->validate([
            'nama_status_delivery' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'nama_status_delivery.required' => 'Nama status delivery wajib diisi.',
            'nama_status_delivery.max' => 'Nama status delivery maksimal 255 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        $status->update($validated);

        return redirect()->route('status-delivery.index')
            ->with('success', 'Status delivery berhasil diperbarui.');
    }

    /**
     * Hapus status delivery.
     */
    public function destroy(string $kode)
    {
        $status = StatusDelivery::findOrFail($kode);

        // Cek apakah status sedang digunakan oleh detail order
        $usedCount = \App\Models\DetailOrder::where('kode_status_delivery', $kode)->count();
        if ($usedCount > 0) {
            return redirect()->route('status-delivery.index')
                ->with('error', "Status delivery \"{$status->nama_status_delivery}\" tidak dapat dihapus karena sedang digunakan oleh {$usedCount} detail order.");
        }

        $status->delete();

        return redirect()->route('status-delivery.index')
            ->with('success', 'Status delivery berhasil dihapus.');
    }
}
