<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('generos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->timestamps();
        });

        $generos = ['Aventura', 'Biografia', 'Fantasia', 'Ficção', 'Geek', 'Infantil', 'Nacional', 'Romance', 'Terror', 'Variados'];

        foreach ($generos as $genero) {
            DB::table('generos')->insert([
                'nome' => $genero,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generos');
    }
};