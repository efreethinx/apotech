<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satuan;

class SatuanController extends Controller
{
    public function index()
    {
        return view('satuan.index');
    }

    public function data()
    {
        $satuan = Satuan::all();

        return datatables()
            ->of($satuan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '
                    <div class="btn-group">
                        <button onclick="editForm(' . $row->id_satuan . ')" class="btn btn-sm btn-info">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button onclick="deleteData(' . $row->id_satuan . ')" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>';
            })
            ->rawColumns(['select_all', 'aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255|unique:satuan,nama_satuan',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $satuan = Satuan::create($request->only(['nama_satuan', 'keterangan']));

        return $this->ok($satuan, 'Data berhasil disimpan');
    }

    public function edit($id_satuan)
    {
        $satuan = Satuan::find($id_satuan);
        if (!$satuan) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        return $this->ok($satuan);
    }

    public function update(Request $request, $id_satuan)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255|unique:satuan,nama_satuan,' . $id_satuan . ',id_satuan',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $satuan = Satuan::find($id_satuan);
        if (!$satuan) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $satuan->update($request->only(['nama_satuan', 'keterangan']));

        return $this->ok($satuan, 'Data berhasil diperbarui');
    }

    public function destroy($id_satuan)
    {
        $satuan = Satuan::find($id_satuan);
        if (!$satuan) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $satuan->delete();

        return $this->ok($satuan, 'Data berhasil dihapus');
    }
}
