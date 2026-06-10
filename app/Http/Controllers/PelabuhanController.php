<?php

namespace App\Http\Controllers;

use App\Models\Pelabuhan;
use Illuminate\Http\Request;

class PelabuhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'staff');
        $pelabuhans = Pelabuhan::all();

        return view('pelabuhan.index', [
            'role' => $role,
            'pageTitle' => 'Kelola Pelabuhan',
            'pelabuhans' => $pelabuhans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelabuhan' => 'required|string|max:255',
            'nama_pulau' => 'required|string|max:255',
            'nama_gudang' => 'required|string|max:255',
            'koordinat' => 'nullable|string|max:255',
        ]);

        Pelabuhan::create($validated);

        return redirect()->back()->with('success', 'Data pelabuhan berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pelabuhan = Pelabuhan::findOrFail($id);

        $validated = $request->validate([
            'nama_pelabuhan' => 'required|string|max:255',
            'nama_pulau' => 'required|string|max:255',
            'nama_gudang' => 'required|string|max:255',
            'koordinat' => 'nullable|string|max:255',
        ]);

        $pelabuhan->update($validated);

        return redirect()->back()->with('success', 'Data pelabuhan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelabuhan = Pelabuhan::findOrFail($id);
        $pelabuhan->delete();

        return redirect()->back()->with('success', 'Data pelabuhan berhasil dihapus!');
    }
}
