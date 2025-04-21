<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran'; // Nama tabel
    protected $primaryKey = 'id_pengeluaran'; // Primary key
    protected $fillable = ['deskripsi', 'nominal']; // Kolom yang bisa diisi

    // Menyimpan timestamp otomatis
    public $timestamps = true;

    // Format tanggal
    protected $dates = ['created_at'];

    // Memformat angka ke dalam bentuk mata uang
    public function nominal(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => format_uang($value),
            set: fn ($value) => str_replace('.', '', $value)
        );
    }
}
