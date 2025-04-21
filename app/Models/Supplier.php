<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';

    protected $fillable = [
        'nama',
        'alamat',
        'no_telepon',
    ];

    // Relasi ke Pembelian (Satu supplier bisa terlibat dalam banyak pembelian)
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_supplier', 'id_supplier');
    }
}
