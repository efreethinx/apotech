<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriStokObat extends Model
{
    use HasFactory;

    protected $table = 'histori_stok_obat'; // Nama tabel

    protected $primaryKey = 'id_histori'; // Menentukan primary key

    protected $fillable = [
        'id_pembelian_detail',
        'id_penjualan_detail',
    ];

    /**
     * Relasi ke model PembelianDetail.
     */
    public function pembelianDetail()
    {
        return $this->belongsTo(PembelianDetail::class, 'id_pembelian_detail', 'id_pembelian_detail');
    }

    /**
     * Relasi ke model PenjualanDetail.
     */
    public function penjualanDetail()
    {
        return $this->belongsTo(PenjualanDetail::class, 'id_penjualan_detail', 'id_penjualan_detail');
    }
}
