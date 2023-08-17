<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmeGen extends Model
{
    use HasFactory;

    public function filme()
    {
        return $this->belongsTo('App\Models\Movie');
    }
    public function genero()
    {
        return $this->belongsTo('App\Models\Genero');
    }
    protected $fillable = [
        'movie_id',
        'genero_id',
    ];
}