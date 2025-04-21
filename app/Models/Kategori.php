<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'keterangan',
    ];

    // Relasi Kategori dengan Obat
    public function obat()
    {
        return $this->hasMany(Obat::class, 'id_kategori', 'id_kategori');
    }
}
