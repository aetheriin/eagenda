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
        Schema::create('naskah_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_naskah');
            $table->string('perihal');
            $table->string('asal_pengirim');
            $table->date('tanggal');
            $table->string('file')->nullable(); 
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('naskah_masuks');
    }
};
