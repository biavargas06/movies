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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('email', 100);
            $table->string('password', 100);
            $table->boolean('isAdmin')->default(false);
            $table->timestamps();
        });

        // Inserir o usuário administrador
        DB::table('usuarios')->insert([
            'nome' => 'Admin',
            'email' => 'golden@admin',
            'password' => '$2y$10$XebnFi6ic0I5G6rGHuf4W.mb3ouVzctA4MBzstJuSHcY3MELZFX2m',
            'isAdmin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};