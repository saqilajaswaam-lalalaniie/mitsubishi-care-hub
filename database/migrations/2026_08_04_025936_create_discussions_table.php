<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke user yang bertanya
            $table->string('title'); // Judul pertanyaan
            $table->string('category'); // Kategori (Mesin, Kelistrikan, AC, dll)
            $table->text('content'); // Isi detail pertanyaan
            $table->string('status')->default('Menunggu'); // Status (Menunggu, Terjawab, Solusi Resmi)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};