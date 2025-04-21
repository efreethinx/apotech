<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembelianDetailController extends Controller
{
    public function index()
    {
        $id_pembelian = session('id_pembelian');
        $supplier = Supplier::find(session('id_supplier'));

        if (!$supplier || !$id_pembelian) abort(404);

        return view('pembelian_detail.index', compact('id_pembelian', 'supplier'));
    }

    public function data($id)
    {
        $data = collect(session('pembelian-' . $id) ?? []);
        $total = 0;
        $totalItem = 0;

        $data = $data->map(function ($item, $index) use (&$total, &$totalItem) {
            $total += $item->subtotal;
            $totalItem += $item->jumlah;

            return [
                'DT_RowIndex' => $index + 1,
                'kode_obat' => $item->obat->kode_obat,
                'nama_obat' => $item->obat->nama_obat,
                'harga_beli' => 'Rp. ' . format_uang($item->obat->harga_beli),
                'jumlah' => '
                    <input type="number" 
                        class="form-control form-control-sm quantity" 
                        data-id="' . $item->id_pembelian_detail . '" 
                        value="' . $item->jumlah . '">
                ',
                'subtotal' => 'Rp. ' . format_uang($item->subtotal),
                'aksi' => '
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $item->id_pembelian_detail . '">
                        <i class="fas fa-trash"></i>
                    </button>
                '
            ];
        });

        $data[] = [
            'kode_obat' => '
                <div class="total hide">' . $total . '</div>
                <div class="total_item hide">' . $totalItem . '</div>',
            'nama_obat' => '',
            'harga_beli'  => '',
            'jumlah'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_obat', 'jumlah'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pembelian' => 'required',
            'id_obat' => 'required|integer',
        ]);

        $obat = Obat::find($request->id_obat);
        if (!$obat) {
            return $this->oops('Data tidak ditemukan', 404);
        }

        $attributes = new \stdClass;
        $attributes->id_pembelian_detail = mt_rand(111111111, 999999999);
        $attributes->id_pembelian = $request->id_pembelian;
        $attributes->obat = $obat;
        $attributes->jumlah = 1;
        $attributes->subtotal = $obat->harga_beli * $attributes->jumlah;
        $attributes->expired_at = now()->addMonths(1);

        $detail = collect(session('pembelian-' . $request->id_pembelian) ?? []);
        $existingItem = $detail->first(function ($item) use ($request) {
            return $item->obat->id_obat == $request->id_obat;
        });

        if ($existingItem) {
            $detail->map(function ($item) use ($existingItem) {
                if ($item->obat->id_obat === $existingItem->obat->id_obat) {
                    $item->jumlah += 1;
                    $item->subtotal = $item->obat->harga_beli * $item->jumlah;
                }

                return $item;
            });
        } else {
            $detail->push($attributes);
        }

        session(['pembelian-' . $request->id_pembelian => $detail]);

        return $this->ok($detail, 'Data berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pembelian' => 'required',
            'jumlah' => 'required|integer|min:1'
        ]);

        $detail = collect(session('pembelian-' . $request->id_pembelian) ?? []);
        $detail->map(function ($item) use ($id, $request) {
            if ($item->id_pembelian_detail == $id) {
                $item->jumlah = (int) $request->jumlah;
                $item->subtotal = $item->obat->harga_beli * $item->jumlah;
            }

            return $item;
        });

        session(['pembelian-' . $request->id_pembelian => $detail]);

        return $this->ok($detail, 'Data berhasil diperbaharui');
    }


    public function destroy(Request $request, $id)
    {
        $request->validate([
            'id_pembelian' => 'required'
        ]);

        $detail = collect(session('pembelian-' . $request->id_pembelian) ?? []);
        $detail = $detail->filter(function ($item) use ($id) {
            return $item->id_pembelian_detail != $id;
        });

        session(['pembelian-' . $request->id_pembelian => $detail]);

        return $this->ok($detail, 'Data berhasil dihapus');
    }

    public function loadForm($diskon, $total)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucfirst(trim(terbilang($bayar) . ' rupiah.'))
        ];

        return $this->ok($data);
    }
}
