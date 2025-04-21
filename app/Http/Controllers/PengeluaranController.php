<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Carbon\Carbon;

class PengeluaranController extends Controller
{

    public function index()
    {
        $pengeluaran = Pengeluaran::all();
        return view('pengeluaran.index', compact('pengeluaran'));
    }

    public function data()
    {
        $pengeluaran = Pengeluaran::select('id_pengeluaran', 'deskripsi', 'nominal', 'created_at')->get();

        return datatables()
            ->of($pengeluaran)
            ->addIndexColumn()
            ->editColumn('nominal', function ($pengeluaran) {
                return $pengeluaran->nominal; // Sudah terformat di model
            })
            ->editColumn('created_at', function ($pengeluaran) {
                return Carbon::parse($pengeluaran->created_at)->translatedFormat('d F Y'); // Format tanggal Indonesia
            })
            ->addColumn('aksi', function ($row) {
                // Tombol untuk edit dan hapus data
                return '
                    <div class="btn-group">
                        <button onclick="editForm(' . $row->id_pengeluaran . ')" class="btn btn-sm btn-info">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button onclick="deleteData(' . $row->id_pengeluaran . ')" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('pengeluaran.create'); // Tampilkan form untuk membuat pengeluaran baru
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'nominal' => 'required|numeric',
        ]);

        $pengeluaran = Pengeluaran::create($request->all());

        return $this->ok($pengeluaran, 'Data berhasil disimpan');
    }

    public function show($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        if (!$pengeluaran) {
            return $this->oops('Data tidak ditemukan', 404);
        }
        return $this->ok($pengeluaran);
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        if (!$pengeluaran) {
            return $this->oops('Data tidak ditemukan', 404);
        }
        return $this->ok($pengeluaran);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'nominal' => 'required|numeric',
        ]);


        $pengeluaran = Pengeluaran::find($id);
        if (!$pengeluaran) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $pengeluaran->update($request->all());

        return $this->ok($pengeluaran, 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        if (!$pengeluaran) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $pengeluaran->delete();

        return $this->ok($pengeluaran, 'Data berhasil dihapus');
    }
}
