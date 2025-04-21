<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('nama')->get();

        return view('pembelian.index', compact('supplier'));
    }

    public function data()
    {
        $pembelian = Pembelian::orderBy('id_pembelian', 'desc')->get();

        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            ->addColumn('total_item', function ($pembelian) {
                return format_uang($pembelian->total_item);
            })
            ->addColumn('total_harga', function ($pembelian) {
                return 'Rp. ' . format_uang($pembelian->total_harga);
            })
            ->addColumn('bayar', function ($pembelian) {
                return 'Rp. ' . format_uang($pembelian->bayar);
            })
            ->addColumn('tanggal', function ($pembelian) {
                return tanggal_indonesia($pembelian->created_at, false);
            })
            ->addColumn('supplier', function ($pembelian) {
                return $pembelian->supplier->nama;
            })
            ->editColumn('diskon', function ($pembelian) {
                return ($pembelian->diskon ?? 0) . '%';
            })
            ->addColumn('aksi', function ($pembelian) {
                return '
                    <div class="btn-group">
                        <button onclick="showDetail(`' . route('pembelian.show', $pembelian->id_pembelian) . '`)" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button onclick="deleteData(`' . route('pembelian.destroy', $pembelian->id_pembelian) . '`)" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id)
    {
        $detail = PembelianDetail::with('obat')->where('id_pembelian', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('kode_obat', function ($detail) {
                return '<span class="badge badge-success">' . $detail->obat->kode_obat . '</span>';
            })
            ->addColumn('nama_obat', function ($detail) {
                return $detail->obat->nama_obat;
            })
            ->addColumn('harga_beli', function ($detail) {
                return 'Rp. ' . format_uang($detail->harga_beli);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->jumlah);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. ' . format_uang($detail->subtotal);
            })
            ->rawColumns(['kode_obat'])
            ->make(true);
    }

    public function supplier()
    {
        $supplier = Supplier::select('id_supplier', 'nama', 'no_telepon', 'alamat')->get();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                return '
                    <a href="' . route('pembelian.create', $supplier->id_supplier) . '"
                        class="btn btn-primary btn-xs">
                        <i class="fas fa-check-circle"></i> Pilih
                    </a>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function obat()
    {
        $obat = Obat::all();

        return datatables()
            ->of($obat)
            ->addIndexColumn()
            ->editColumn('kode_obat', function ($obat) {
                return '<span class="badge badge-success">' . $obat->kode_obat . '</span>';
            })
            ->addColumn('aksi', function ($obat) {
                return '
                    <a href="' . route('pembelian.create', $obat->id_obat) . '"
                        class="btn btn-primary btn-xs pilih-obat"
                        data-id="' . $obat->id_obat . '" 
                        data-nama="' . $obat->nama_obat . '"
                        data-harga="' . format_uang($obat->harga_beli) . '">
                        <i class="fas fa-check-circle"></i> Pilih
                    </a>
                ';
            })
            ->rawColumns(['kode_obat', 'aksi'])
            ->make(true);
    }

    public function create($id_supplier)
    {
        session(['id_supplier' => $id_supplier]);
        session(['id_pembelian' => mt_rand(111111111, 999999999)]);

        return to_route('pembelian.transaksi.index');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id_pembelian' => 'required',
                'total_item' => 'required|integer',
                'total' => 'required|numeric',
                'diskon' => 'required|numeric|min:0|max:100',
                'bayar' => 'required|numeric',
            ]);

            $data = collect(session('pembelian-' . $request->id_pembelian));
            if (!$data) {
                throw new \Exception('Data tidak ditemukan');
            }

            $pembelian = new Pembelian();
            $pembelian->id_supplier = session('id_supplier');
            $pembelian->total_item  = $request->total_item;
            $pembelian->total_harga = $request->total;
            $pembelian->metode_pembayaran = 'cash';
            $pembelian->bayar = $request->bayar;
            $pembelian->save();

            PembelianDetail::insert(
                $data->map(function ($item) use ($pembelian, $request) {
                    return [
                        'id_pembelian' => $pembelian->id_pembelian,
                        'id_obat' => $item->obat->id_obat,
                        'harga_beli' => $item->obat->harga_beli,
                        'jumlah' => $item->jumlah,
                        'diskon' => $request->diskon,
                        'subtotal' => $item->subtotal,
                        'expired_at' => $item->expired_at,
                    ];
                })->toArray()
            );

            session()->forget('id_supplier');
            session()->forget('pembelian-' . $request->id_pembelian);
            session()->save();

            DB::commit();

            return to_route('pembelian.index')->with([
                'success_msg' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return to_route('pembelian.transaksi.index')->with([
                'error_msg' => true,
                'message' => 'Data gagal disimpan'
            ]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pembelian = Pembelian::find($id);
            if (!$pembelian) {
                throw new \Exception('Data tidak ditemukan');
            }
            $pembelian->delete();

            DB::commit();

            return $this->ok($pembelian, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->oops($e->getMessage());
        }
    }
}
