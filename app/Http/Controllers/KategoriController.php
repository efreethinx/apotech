<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index');
    }

    public function data()
    {
        $kategori = Kategori::all();

        return datatables()
            ->of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '
                    <div class="btn-group">
                        <button onclick="editForm(' . $row->id_kategori . ')" class="btn btn-sm btn-info">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button onclick="deleteData(' . $row->id_kategori . ')" class="btn btn-sm btn-danger">
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
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $kategori = Kategori::create($request->only(['nama_kategori', 'keterangan']));

        return $this->ok($kategori, 'Data berhasil disimpan');
    }

    public function edit($id_kategori)
    {
        $kategori = Kategori::find($id_kategori);
        if (!$kategori) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        return $this->ok($kategori);
    }

    public function update(Request $request, $id_kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $id_kategori . ',id_kategori',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $kategori = Kategori::find($id_kategori);
        if (!$kategori) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $kategori->update($request->only(['nama_kategori', 'keterangan']));

        return $this->ok($kategori, 'Data berhasil diperbarui');
    }


    public function destroy($id_kategori)
    {
        $kategori = Kategori::find($id_kategori);
        if (!$kategori) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $kategori->delete();

        return $this->ok($kategori, 'Data berhasil dihapus');
    }
}
