<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';
    protected $primaryKey = 'id_obat';

    protected $fillable = [
        'id_kategori',
        'id_satuan',
        'kode_obat',
        'nama_obat',
        'merk_obat',
        'harga_beli',
        'harga_jual',
        'keterangan',
    ];

    public function hargaBeli(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => format_uang($value),
            set: fn ($value) => str_replace('.', '', $value)
        );
    }
    
    public function hargaJual(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => format_uang($value),
            set: fn ($value) => str_replace('.', '', $value)
        );
    }

    // Relasi ke Kategori (Setiap obat terkait dengan satu kategori)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // Relasi ke Satuan (Setiap obat terkait dengan satu satuan)
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id_satuan');
    }

    // Relasi ke StokObat (Satu obat bisa memiliki banyak stok)
    public function stokObat()
    {
        return $this->hasMany(StokObat::class, 'id_obat', 'id_obat');
    }

    // Relasi ke StokOpname (Satu obat bisa memiliki banyak stok opname)
    public function stokOpname()
    {
        return $this->hasMany(StokOpname::class, 'id_obat', 'id_obat');
    }

    // Relasi ke PenjualanDetail (Satu obat bisa muncul di banyak detail penjualan)
    public function penjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_obat', 'id_obat');
    }

    // Relasi ke PembelianDetail (Satu obat bisa muncul di banyak detail pembelian)
    public function pembelianDetail()
    {
        return $this->hasMany(PembelianDetail::class, 'id_obat', 'id_obat');
    }
}
