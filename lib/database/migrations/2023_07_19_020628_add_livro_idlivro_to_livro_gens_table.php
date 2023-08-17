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
        Schema::table('movies_gens', function (Blueprint $table) {
            $table->foreignId('filme_id')->constrained()->onDelete('cascade');
            $table->foreignId('genero_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('filme_gens', function (Blueprint $table) {
            $table->foreignId('filme_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('genero_id')
                ->constrained()
                ->onDelete('cascade');
        });
    }
};