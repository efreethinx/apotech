<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'setting'; // Nama tabel

    protected $primaryKey = 'id_setting'; // Menentukan primary key

    protected $fillable = [
        'nama_apotek',
        'nama_owner',
        'alamat',
        'no_telepon',
        'email_apotek',
        'jam_buka',
        'jam_tutup',
        'diskon_member',
        'path_logo',
        'path_kartu_member',
    ];

    protected $appends = [
        'url_logo',
        'url_kartu_member'
    ];

    public function urlLogo(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => '/storage' . $attributes['path_logo']
        );
    }

    public function urlKartuMember(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => '/storage' . $attributes['path_kartu_member']
        );
    }
}
