<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        return view('supplier.index');
    }

    public function data()
    {
        $supplier = Supplier::select('id_supplier', 'nama', 'no_telepon', 'alamat')->get();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(' . $supplier->id_supplier . ')" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" onclick="deleteData(' . $supplier->id_supplier . ')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $supplier = Supplier::create($request->only(['nama', 'no_telepon', 'alamat']));

        return $this->ok($supplier, 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        return $this->ok($supplier);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $supplier = Supplier::find($id);

        if (!$supplier) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $supplier->update($request->only(['nama', 'no_telepon', 'alamat']));

        return $this->ok($supplier, 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        // Hapus semua data pembelian terkait
        $supplier->pembelian()->delete();

        $supplier->delete();

        return $this->ok($supplier, 'Data berhasil dihapus');
    }
}
