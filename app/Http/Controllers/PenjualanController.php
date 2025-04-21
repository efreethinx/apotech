<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Obat;
use App\Models\Setting;
use Illuminate\Http\Request;
use PDF;

class PenjualanController extends Controller
{
    public function index()
    {
        return view('penjualan.index');
    }

    public function data()
    {
        $penjualan = Penjualan::with('member')->orderBy('id_penjualan', 'desc')->get();

        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('total_item', function ($penjualan) {
                return format_uang($penjualan->total_item);
            })
            ->addColumn('total_harga', function ($penjualan) {
                return 'Rp. ' . format_uang($penjualan->total_harga);
            })
            ->addColumn('bayar', function ($penjualan) {
                return 'Rp. ' . format_uang($penjualan->bayar);
            })
            ->addColumn('tanggal', function ($penjualan) {
                return tanggal_indonesia($penjualan->created_at, false);
            })
            ->addColumn('id_member', function ($penjualan) {
                $member = $penjualan->member->kode_member ?? '';
                return '<span class="label label-success">' . $member . '</span>';
            })
            ->editColumn('diskon', function ($penjualan) {
                return $penjualan->diskon . '%';
            })
            ->editColumn('kasir', function ($penjualan) {
                return $penjualan->user->name ?? '';
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`' . route('penjualan.show', $penjualan->id_penjualan) . '`)" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                    <button onclick="deleteData(`' . route('penjualan.destroy', $penjualan->id_penjualan) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'id_member'])
            ->make(true);
    }

    public function create()
    {
        $penjualan = new Penjualan();
        $penjualan->id_member = null;
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->diskon = 0;
        $penjualan->bayar = 0;
        $penjualan->diterima = 0;
        $penjualan->id_user = auth()->id();
        $penjualan->save();

        session(['id_penjualan' => $penjualan->id_penjualan]);
        return redirect()->route('transaksi.index');
    }

    public function store(Request $request)
    {
        $penjualan = Penjualan::find($request->id_penjualan);
        if (!$penjualan) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $penjualan->update([
            'id_member' => $request->id_member,
            'total_item' => $request->total_item,
            'total_harga' => $request->total,
            'diskon' => $request->diskon,
            'bayar' => $request->bayar,
            'diterima' => $request->diterima,
        ]);

        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach ($detail as $item) {
            $item->update(['diskon' => $request->diskon]);

            $obat = Obat::find($item->id_obat);
            $obat->stok -= $item->jumlah;
            $obat->update();
        }

        return $this->ok($penjualan, 'Transaksi berhasil disimpan');
    }

    public function show($id)
    {
        $detail = PenjualanDetail::with('obat')->where('id_penjualan', $id)->get();

        if ($detail->isEmpty()) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('nama_obat', function ($detail) {
                return $detail->obat->nama_obat;
            })
            ->addColumn('harga_jual', function ($detail) {
                return 'Rp. ' . format_uang($detail->harga_jual);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->jumlah);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. ' . format_uang($detail->subtotal);
            })
            ->make(true);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        if (!$penjualan) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach ($detail as $item) {
            $obat = Obat::find($item->id_obat);
            if ($obat) {
                $obat->stok += $item->jumlah;
                $obat->update();
            }

            $item->delete();
        }

        $penjualan->delete();

        return $this->ok(null, 'Data berhasil dihapus');
    }

    public function selesai()
    {
        $setting = Setting::first();

        return view('penjualan.selesai', compact('setting'));
    }

    
}
