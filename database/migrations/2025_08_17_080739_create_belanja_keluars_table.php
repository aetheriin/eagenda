<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('belanja_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_naskah'); 
            
            // Relasi
            $table->foreignId('bagian_fungsi_id')
                  ->constrained('bagian_fungsis')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignId('klasifikasi_naskah_id')
                  ->constrained('klasifikasi_naskahs')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->string('perihal');
            $table->string('tujuan_penerima');
            $table->date('tanggal');
            $table->string('file')-> nullable(); 
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('belanja_keluars');
    }
};
