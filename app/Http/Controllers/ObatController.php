<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        $satuan = Satuan::all()->pluck('nama_satuan', 'id_satuan'); // Ambil data satuan
        
        return view('obat.index', compact('kategori', 'satuan')); // Kirim ke view
    }

    public function data()
    {
        $obat = Obat::leftJoin('kategori', 'kategori.id_kategori', 'obat.id_kategori')
            ->leftJoin('satuan', 'satuan.id_satuan', 'obat.id_satuan') // Tambahkan join ke tabel satuan
            ->select('obat.*', 'nama_kategori', 'nama_satuan') // Ambil nama_satuan
            ->get();

        return datatables()
            ->of($obat)
            ->addIndexColumn()
            ->addColumn('select_all', function ($obat) {
                return '
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="checkbox-' . $obat->id_obat . '" name="id_obat[]" value="' . $obat->id_obat . '">
                        <label class="custom-control-label" for="checkbox-' . $obat->id_obat . '"></label>
                    </div>
                ';
            })
            ->editColumn('kode_obat', function ($obat) {
                return '<span class="badge badge-success">' . $obat->kode_obat . '</span>';
            })
            ->addColumn('harga_beli', function ($obat) {
                return format_uang($obat->harga_beli);
            })
            ->addColumn('harga_jual', function ($obat) {
                return format_uang($obat->harga_jual);
            })
            ->addColumn('aksi', function ($row) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(' . $row->id_obat . ')" class="btn btn-sm btn-info">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    <button onclick="deleteData(' . $row->id_obat . ')" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                </div>
                ';
            })
            ->rawColumns(['kode_obat', 'aksi', 'select_all'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id_kategori'   => 'required|exists:kategori,id_kategori',
            'id_satuan'      => 'required|exists:satuan,id_satuan',
            'kode_obat'      => 'required|string|max:255|unique:obat,kode_obat',
            'nama_obat'      => 'required|string|max:255',
            'merk_obat'      => 'nullable|string|max:255',
            'harga_beli'     => 'required|numeric|min:0',
            'harga_jual'     => 'required|numeric|min:0',
            'keterangan'     => 'nullable|string|max:255',
        ]);

        // Create the new Obat record using only the necessary fields from the request
        $obat = Obat::create($request->only([
            'id_kategori',
            'id_satuan',
            'kode_obat',
            'nama_obat',
            'merk_obat',
            'harga_beli',
            'harga_jual',
            'keterangan'
        ]));

        // Return a success response with the created Obat
        return $this->ok($obat, 'Data berhasil disimpan');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obat = Obat::find($id);

        return $this->ok($obat);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id_obat
     * @return \Illuminate\Http\Response
     */
    public function edit($id_obat)
    {
        $obat = Obat::find($id_obat);
        if (!$obat) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        return $this->ok($obat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_obat)
    {
        // Validate the incoming request data
        $request->validate([
            'id_kategori'   => 'required|exists:kategori,id_kategori',
            'id_satuan'      => 'required|exists:satuan,id_satuan',
            'kode_obat'      => 'required|string|max:255|unique:obat,kode_obat,' . $id_obat . ',id_obat',
            'nama_obat'      => 'required|string|max:255',
            'merk_obat'      => 'nullable|string|max:255',
            'harga_beli'     => 'required|numeric|min:0',
            'harga_jual'     => 'required|numeric|min:0',
            'keterangan'     => 'nullable|string|max:255',
        ]);

        // Find the Obat by its ID
        $obat = Obat::find($id_obat);
        if (!$obat) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        // Update the Obat record with the validated data
        $obat->update($request->only([
            'id_kategori',
            'id_satuan',
            'kode_obat',
            'nama_obat',
            'merk_obat',
            'harga_beli',
            'harga_jual',
            'keterangan'
        ]));

        // Return a success response with the updated Obat
        return $this->ok($obat, 'Data berhasil diperbarui');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id_obat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_obat)
    {
        $obat = Obat::find($id_obat);
        if (!$obat) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $obat->delete();

        return $this->ok($obat, 'Data berhasil dihapus');
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_obat as $id) {
            $obat = Obat::find($id);
            $obat->delete();
        }

        return $this->ok($obat, 'Data berhasil dihapus');
    }
}
