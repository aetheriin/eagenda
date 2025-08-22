<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klasifikasi_naskahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_klasifikasi');   // contoh: "PERENCANAAN"
            $table->string('kode_klasifikasi');   // contoh: "SS.000"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klasifikasi_naskahs');
    }
};
