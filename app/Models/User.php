<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'no_telepon',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'role',
        'path_foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'tanggal_lahir' => 'date',
    ];

    protected $appends = [
        'url_foto'
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function urlFoto(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => '/storage' . $attributes['path_foto']
        );
    }
}
