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
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        // Foreign key ke tabel users
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('plat_nomor')->unique();
        $table->string('tipe_mobil'); 
        $table->integer('tahun');
        $table->string('warna');
        $table->string('no_rangka')->unique();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
