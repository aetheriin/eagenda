<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('memorandum_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_naskah');
            $table->string('bagian_fungsi');
            $table->string('klasifikasi');
            $table->string('perihal');
            $table->string('tujuan_penerima');
            $table->date('tanggal');
            $table->string('file');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorandum_keluars');
    }
};
