<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\peternak;

class PeternakController extends Controller
{
    public function index(){
        $peternak = Peternak::all();

        return view('peternak.index',[
            'peternak' => $peternak
        ] );
     }

     public function store(Request $request)
    {
        $request->validate([
            'nama_peternak' => 'required|string|max:255',
            'no_daerah' => 'required|string|max:50',
            'simpan_pinjam' => 'required|numeric',
        ]);

        Peternak::create([
            'nama_peternak' => $request->nama_peternak,
            'no_daerah' => $request->no_daerah,
            'simpan_pinjam' => $request->simpan_pinjam,
        ]);

        return redirect()->back()->with('success', 'Data peternak berhasil ditambahkan.');
    }

    /**
     * Update data peternak yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_peternak' => 'required|string|max:255',
            'no_daerah' => 'required|string|max:50',
            'simpan_pinjam' => 'required|numeric|min:0',
        ]);

        $peternak = Peternak::findOrFail($id);
        $peternak->update([
            'nama_peternak' => $request->nama_peternak,
            'no_daerah' => $request->no_daerah,
            'simpan_pinjam' => $request->simpan_pinjam,
        ]);

        return redirect()->back()->with('success', 'Data peternak berhasil diperbarui.');
    }


    public function destroy($id)
{
    $peternak = Peternak::findOrFail($id);
    $peternak->delete();

    return redirect()->back()->with('success', 'Data peternak berhasil dihapus.');
}
}
