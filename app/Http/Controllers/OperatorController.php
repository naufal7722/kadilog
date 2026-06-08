<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'staff');
        $operators = Operator::all();

        return view('operators.index', [
            'role' => $role,
            'pageTitle' => 'Kelola Operator',
            'operators' => $operators,
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
