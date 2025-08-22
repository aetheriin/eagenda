<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bagian_fungsis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bagian'); // contoh: "BPS Provinsi Riau"
            $table->string('kode_bps');    // contoh: "12.07"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bagian_fungsis');
    }
};
