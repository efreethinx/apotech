<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'member';
    protected $primaryKey = 'id_member';

    protected $fillable = [
        'nama',
        'no_telepon',
        'alamat',
    ];

    // Relasi ke Penjualan (Satu member bisa terlibat dalam banyak penjualan)
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_member', 'id_member');
    }
}
