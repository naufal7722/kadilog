<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\Pelabuhan;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'staff');
        // Get operators with their assigned pelabuhan
        $operators = Operator::with('pelabuhan')->get();
        // Group pelabuhans by island name for the dropdown
        $pelabuhans = Pelabuhan::all()->groupBy('nama_pulau');

        return view('operators.index', [
            'role' => $role,
            'pageTitle' => 'Kelola Operator',
            'operators' => $operators,
            'pelabuhans' => $pelabuhans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_operator' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'kode_pelabuhan' => 'required|exists:pelabuhans,kode_pelabuhan',
        ]);

        Operator::create($validated);

        return redirect()->back()->with('success', 'Data operator berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $operator = Operator::findOrFail($id);

        $validated = $request->validate([
            'nama_operator' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'kode_pelabuhan' => 'required|exists:pelabuhans,kode_pelabuhan',
        ]);

        $operator->update($validated);

        return redirect()->back()->with('success', 'Data operator berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $operator = Operator::findOrFail($id);
        $operator->delete();

        return redirect()->back()->with('success', 'Data operator berhasil dihapus!');
    }
}
