<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'password', 'isAdmin'];
    protected $hidden = ['password'];

    protected $casts = [
        'isAdmin' => 'boolean',
    ];

    public function carrinho()
    {
        return $this->belongsToMany(filme::class, 'carrinhos', 'usuario_id', 'filme_id')
            ->withPivot('quantidade');
    }
}