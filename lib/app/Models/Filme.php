<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filmes extends Model
{
    use HasFactory;

    protected $table = 'Filmes';

    protected $fillable = [
        'nome',
        'ano_lancamento',
        'sinopse',
        'url_video',
        'imagem',
    ];

  
    public function generos()
    {
        return $this->belongsToMany(Genero::class, 'filmes_gens', 'filmes_id', 'genero_id');
    }
}