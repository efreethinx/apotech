<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // Example of dummy data
        $laporan = [
            ['tanggal' => '2021-05-01', 'penjualan' => 1000000, 'pembelian' => 500000, 'pengeluaran' => 200000, 'pendapatan' => 300000],
            ['tanggal' => '2021-05-02', 'penjualan' => 1200000, 'pembelian' => 600000, 'pengeluaran' => 250000, 'pendapatan' => 350000],
            ['tanggal' => '2021-05-03', 'penjualan' => 1100000, 'pembelian' => 550000, 'pengeluaran' => 220000, 'pendapatan' => 330000],
            ['tanggal' => '2021-05-04', 'penjualan' => 1300000, 'pembelian' => 650000, 'pengeluaran' => 270000, 'pendapatan' => 380000],
            ['tanggal' => '2021-05-05', 'penjualan' => 1250000, 'pembelian' => 620000, 'pengeluaran' => 240000, 'pendapatan' => 350000],
        ];

        return view('laporan.index', compact('laporan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|string|max:255|unique:laporan,tanggal_awal',
            'tanggal_akhir' => 'nullable|string|max:255',
        ]);

        $laporan = Laporan::create($request->only(['tanggal_awal', 'tanggal_akhir']));

        return $this->ok($laporan, 'Data berhasil disimpan');
    }
}