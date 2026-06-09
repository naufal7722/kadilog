<?php

namespace App\Http\Controllers;

use App\Models\Rute;
use App\Models\Pelabuhan;
use Illuminate\Http\Request;

class RuteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'staff');
        $rutes = Rute::with('pelabuhan')->get();
        $pelabuhans = Pelabuhan::all();

        return view('rute.index', [
            'role' => $role,
            'pageTitle' => 'Kelola Rute',
            'rutes' => $rutes,
            'pelabuhans' => $pelabuhans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_pelabuhan' => 'required|exists:pelabuhans,kode_pelabuhan',
            'jarak' => 'required|numeric|min:0',
        ]);

        Rute::create($validated);

        return redirect()->back()->with('success', 'Data rute berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rute = Rute::findOrFail($id);

        $validated = $request->validate([
            'kode_pelabuhan' => 'required|exists:pelabuhans,kode_pelabuhan',
            'jarak' => 'required|numeric|min:0',
        ]);

        $rute->update($validated);

        return redirect()->back()->with('success', 'Data rute berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rute = Rute::findOrFail($id);
        $rute->delete();

        return redirect()->back()->with('success', 'Data rute berhasil dihapus!');
    }
}
