<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use Illuminate\Http\Request;

class KonsumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'staff');
        $konsumens = Konsumen::all();

        return view('konsumen.index', [
            'role' => $role,
            'pageTitle' => 'Kelola Konsumen',
            'konsumens' => $konsumens,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_konsumen' => 'required|string|max:255',
            'nama_pic_konsumen' => 'required|string|max:255',
        ]);

        Konsumen::create($validated);

        return redirect()->back()->with('success', 'Data konsumen berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $konsumen = Konsumen::findOrFail($id);

        $validated = $request->validate([
            'nama_konsumen' => 'required|string|max:255',
            'nama_pic_konsumen' => 'required|string|max:255',
        ]);

        $konsumen->update($validated);

        return redirect()->back()->with('success', 'Data konsumen berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $konsumen = Konsumen::findOrFail($id);
        $konsumen->delete();

        return redirect()->back()->with('success', 'Data konsumen berhasil dihapus!');
    }
}
