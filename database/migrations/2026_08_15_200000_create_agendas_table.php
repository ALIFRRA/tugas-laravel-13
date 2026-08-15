<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori'); // Latihan Band, Festival Sekolah, Workshop, UKK, Konseling, dll
            $table->string('tanggal');
            $table->string('jam')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->text('personel')->nullable();
            $table->string('status')->default('Aktif'); // Aktif, Persiapan, Mendatang, Selesai
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
