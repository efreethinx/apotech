<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Obat;
use App\Models\Setting;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $obat = Obat::orderBy('nama_obat')->get();
        $member = Member::orderBy('nama')->get();
        $diskon = Setting::first()->diskon ?? 0;

        // Cek apakah ada transaksi yang sedang berjalan
        if ($id_penjualan = session('id_penjualan')) {
            $penjualan = Penjualan::find($id_penjualan);
            $memberSelected = $penjualan->member ?? new Member();

            return view('penjualan_detail.index', compact('obat', 'member', 'diskon', 'id_penjualan', 'penjualan', 'memberSelected'));
        } else {
            return auth()->user()->level == 1 ? redirect()->route('transaksi.baru') : redirect()->route('home');
        }
    }

    public function data($id)
    {
        $detail = PenjualanDetail::with('obat')->where('id_penjualan', $id)->get();
        $data = [];
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $data[] = [
                'nama_obat' => $item->obat['nama_obat'],
                'harga_jual' => 'Rp. ' . format_uang($item->harga_jual),
                'jumlah' => '<input type="number" class="form-control input-sm quantity" data-id="' . $item->id_penjualan_detail . '" value="' . $item->jumlah . '">',
                'diskon' => $item->diskon . '%',
                'subtotal' => 'Rp. ' . format_uang($item->subtotal),
                'aksi' => '<div class="btn-group">
                            <button onclick="deleteData(`' . route('transaksi.destroy', $item->id_penjualan_detail) . '`)" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>'
            ];
            $total += $item->harga_jual * $item->jumlah - (($item->diskon * $item->jumlah) / 100 * $item->harga_jual);
            $total_item += $item->jumlah;
        }

        return datatables()->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'jumlah'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $obat = Obat::where('id_obat', $request->id_obat)->first();
        if (!$obat) {
            return $this->oops('Data gagal disimpan', 400);
        }

        $detail = new PenjualanDetail();
        $detail->fill([
            'id_penjualan' => $request->id_penjualan,
            'id_obat' => $obat->id_obat,
            'harga_jual' => $obat->harga_jual,
            'jumlah' => 1,
            'diskon' => $obat->diskon,
            'subtotal' => $obat->harga_jual
        ]);
        $detail->save();

        return $this->ok($detail, 'Data berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $detail = PenjualanDetail::find($id);
        if (!$detail) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_jual * $request->jumlah - (($detail->diskon * $request->jumlah) / 100 * $detail->harga_jual);
        $detail->update();

        return $this->ok($detail, 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        if (!$detail) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $detail->delete();
        return $this->ok($detail, 'Data berhasil dihapus');
    }

    public function loadForm($diskon = 0, $total = 0, $diterima = 0)
    {
        $diskon = (float) $diskon;
        $total = (float) $total;
        $diterima = (float) $diterima;

        $bayar = $total - ($diskon / 100 * $total);
        $kembali = $diterima ? $diterima - $bayar : 0;

        $data = [
            'totalrp' => 'Rp. ' . number_format($total, 0, ',', '.'),
            'bayar' => $bayar,
            'bayarrp' => 'Rp. ' . number_format($bayar, 0, ',', '.'),
            'terbilang' => 'Nol Rupiah',
            'kembalirp' => 'Rp. ' . number_format($kembali, 0, ',', '.'),
            'kembali_terbilang' => 'Nol Rupiah',
        ];

        return response()->json($data);
    }
}
