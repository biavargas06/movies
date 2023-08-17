<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'generos';

    protected $fillable = ['id', 'nome'];

    public function filmes()
    {
        return $this->belongsToMany(filme::class, 'filme_gen', 'genero_id', 'filme_id');
    }
}