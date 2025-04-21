<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Satuan extends Model
{
    use HasFactory;

    protected $table = 'satuan';
    protected $primaryKey = 'id_satuan';

    protected $fillable = [
        'nama_satuan',
        'keterangan',
    ];

    // Relasi Satuan dengan Obat
    public function obat()
    {
        return $this->hasMany(Obat::class, 'id_satuan', 'id_satuan');
    }
}
