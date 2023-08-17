<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function itens()
    {
        return $this->hasMany(Carrinho::class);
    }
}