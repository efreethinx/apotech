<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokObat;
use App\Models\StokOpname;
use App\Models\Obat;

class StockOpnameController extends Controller
{

    public function index()
    {
        $obat = Obat::all()->pluck('nama_obat', 'id_obat');
        $stok_obat = StokObat::with('obat')->get();
        $stok_opname = StokOpname::with('obat')->get();

        return view('stockopname.index', compact('obat', 'stok_obat', 'stok_opname'));
    }


    public function stokObatData()
    {
        $stok_obat = StokObat::with('obat')->get();

        return datatables()
            ->of($stok_obat)
            ->addIndexColumn()
            ->addColumn('obat.nama_obat', fn($row) => $row->obat->nama_obat ?? '-')
            ->addColumn(
                'stok_status',
                fn($row) => $row->stok > 0
                    ? '<span class="badge bg-success">Stok Tersedia</span>'
                    : '<span class="badge bg-danger">Stok Habis</span>'
            )
            ->rawColumns(['stok_status'])
            ->make(true);
    }

    public function stokOpnameData()
    {
        $stok_opname = StokOpname::with('obat')->get();

        return datatables()
            ->of($stok_opname)
            ->addIndexColumn()
            ->addColumn('obat.nama_obat', fn($row) => $row->obat->nama_obat ?? '-')
            ->addColumn('jumlah', fn($row) => $row->stok_fisik - $row->stok_tercatat)
            ->addColumn(
                'aksi',
                fn($row) => '
            <button class="btn btn-danger btn-sm" onclick="deleteData(' . $row->id . ')">
                <i class="fas fa-trash"></i> Hapus
            </button>'
            )
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function getStokObat($id_obat)
    {
        $stok = StokObat::where('id_obat', $id_obat)->value('stok');

        if ($stok !== null) {
            return response()->json(['stok' => $stok]);
        }

        return response()->json(['stok' => 0], 404);
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_obat' => 'required|exists:obat,id_obat',
            'stok_tercatat' => 'required|integer',
            'stok_fisik' => 'required|integer',
        ]);

        $jumlah_selisih = $request->stok_fisik - $request->stok_tercatat;

        StokObat::updateOrCreate(
            ['id_obat' => $request->id_obat],
            ['stok' => $request->stok_fisik]
        );

        StokOpname::create([
            'id_obat' => $request->id_obat,
            'stok_tercatat' => $request->stok_tercatat,
            'stok_fisik' => $request->stok_fisik,
            'jumlah' => $jumlah_selisih,
        ]);

        return response()->json(['message' => 'Data stok berhasil ditambahkan']);
    }


    public function destroy($id)
    {
        $stok_opname = StokOpname::findOrFail($id);
        $stok_opname->delete();

        return redirect()->route('stok-opname')->with('success', 'Data stok opname berhasil dihapus!');
    }
}
