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
        Schema::table('livro_gens', function (Blueprint $table) {
            $table->foreignId('livro_id')->constrained()->onDelete('cascade');
            $table->foreignId('genero_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('livro_gens', function (Blueprint $table) {
            $table->foreignId('livro_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('genero_id')
                ->constrained()
                ->onDelete('cascade');
        });
    }
};