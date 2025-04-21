<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokObat extends Model
{
    use HasFactory;

    protected $table = 'stok_obat'; // Nama tabel

    protected $primaryKey = 'id_stok_obat'; // Menentukan primary key

    protected $fillable = [
        'id_obat',
        'stok',
        'tanggal_update',
    ];

    /**
     * Relasi ke model Obat.
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat', 'id_obat'); // Menghubungkan dengan model Obat
    }

    /**
     * Menambahkan stok obat.
     *
     * @param int $jumlah
     * @return void
     */
    public function tambahStok($jumlah)
    {
        $this->stok += $jumlah;
        $this->tanggal_update = now();
        $this->save();
    }

    /**
     * Mengurangi stok obat.
     *
     * @param int $jumlah
     * @return void
     */
    public function kurangiStok($jumlah)
    {
        $this->stok -= $jumlah;
        $this->tanggal_update = now();
        $this->save();
    }
}
