<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    use HasFactory;

    protected $table = 'stok_opname'; // Nama tabel

    protected $primaryKey = 'id_stok_opname'; // Menentukan primary key

    protected $fillable = [
        'id_obat',
        'stok_tercatat',
        'stok_fisik',
        'jumlah',
    ];

    /**
     * Relasi ke model Obat.
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat', 'id_obat'); // Menghubungkan dengan model Obat
    }

    /**
     * Menghitung selisih antara stok tercatat dan stok fisik.
     *
     * @return int
     */
    public function selisih()
    {
        return $this->stok_tercatat - $this->stok_fisik;
    }
}
