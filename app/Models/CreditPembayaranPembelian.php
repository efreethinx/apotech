<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditPembayaranPembelian extends Model
{
    use HasFactory;
    
    protected $table = 'credit_pembayaran_pembelian';
    protected $primaryKey = 'id_credit';
    protected $fillable = ['id_pembelian', 'tanggal_bayar', 'subtotal'];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }
}

