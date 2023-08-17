<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivroGen extends Model
{
    use HasFactory;

    public function livro()
    {
        return $this->belongsTo('App\Models\Livro');
    }
    public function genero()
    {
        return $this->belongsTo('App\Models\Genero');
    }
    protected $fillable = [
        'livro_id',
        'genero_id',
    ];
}