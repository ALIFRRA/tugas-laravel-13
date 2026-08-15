<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->string('jenis_pelanggaran');
            $table->string('kategori')->default('Ringan'); // Ringan, Sedang, Berat
            $table->integer('poin')->default(5);
            $table->string('sanksi')->nullable();
            $table->string('tanggal');
            $table->string('guru_pencatat')->nullable();
            $table->string('status')->default('Dalam Pembinaan'); // Dalam Pembinaan, Selesai, Ditindaklanjuti
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
    }
};
