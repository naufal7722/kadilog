<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'staff');
        $suppliers = Supplier::all();

        return view('suppliers.index', [
            'role' => $role,
            'pageTitle' => 'Kelola Supplier',
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_umkm' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nama_pic' => 'required|string|max:255',
            'no_hp_pic' => 'required|string|max:255',
        ]);

        Supplier::create($validated);

        return redirect()->back()->with('success', 'Data supplier berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'nama_umkm' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nama_pic' => 'required|string|max:255',
            'no_hp_pic' => 'required|string|max:255',
        ]);

        $supplier->update($validated);

        return redirect()->back()->with('success', 'Data supplier berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->back()->with('success', 'Data supplier berhasil dihapus!');
    }
}
