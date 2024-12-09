<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setoran;
use App\Models\Peternak;

class SetoranController extends Controller
{
    public function index(Request $request)
{
    // Ambil parameter search jika ada
    $search = $request->input('search');
    $peternak = Peternak::all();
    // Query setoran dengan relasi ke peternak
    $setoran = Setoran::with('peternak')
        ->when($search, function ($query, $search) {
            return $query->whereHas('peternak', function ($query) use ($search) {
                $query->where('nama_peternak', 'like', "%{$search}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(8);

    return view('data-setoran.setoran-susu', compact('setoran', 'peternak'));
}

public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'peternak_id' => 'required|exists:peternaks,id',  // Validasi peternak_id
            'setoran_pagi' => 'required|numeric|min:0',
            'setoran_sore' => 'required|numeric|min:0',
            'jumlah_setoran' => 'required|numeric|min:0',
            'tanggal_setoran' => 'required|date', 
        ]);

        // Ambil data peternak berdasarkan peternak_id
        $peternak = Peternak::find($request->peternak_id);

        // Hitung jumlah setoran berdasarkan setoran pagi dan sore
        $total_liter = $request->setoran_pagi + $request->setoran_sore;
        $harga_per_liter = 7600;  // Harga per liter susu
        $jumlah_setoran = $total_liter * $harga_per_liter;

        // Simpan data setoran ke dalam tabel setoran
        $setoran = Setoran::create([
            'peternak_id' => $peternak->id,
            'jumlah_pagi' => $request->setoran_pagi,
            'jumlah_sore' => $request->setoran_sore,
            'jumlah_setoran' => $jumlah_setoran,  // Menyimpan total setoran
            'tanggal_setoran' => $request->tanggal_setoran, 
        ]);

        // Update kolom simpan_pinjam pada tabel peternak
        $peternak->simpan_pinjam += $jumlah_setoran;  // Menambahkan jumlah setoran ke simpan_pinjam
        $peternak->save();  // Simpan perubahan pada tabel peternak

        return redirect()->route('setoran.index')->with('success', 'Data setoran berhasil disimpan dan simpan_pinjam diperbarui!');
    }

public function search(Request $request)
    {
        $query = $request->input('query');

        // Cari peternak berdasarkan nama, sertakan no_daerah
        $peternak = Peternak::where('nama_peternak', 'like', '%' . $query . '%')
                            ->select('id', 'nama_peternak', 'no_daerah')
                            ->get();

        return response()->json($peternak);
    }
}


