<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $fillable = ['id_user', 'id_member', 'total_item', 'total_harga', 'diskon', 'bayar', 'diterima', 'kembalian'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_penjualan');
    }
}
