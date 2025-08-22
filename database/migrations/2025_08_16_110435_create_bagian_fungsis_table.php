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
            $table->string('nama_bagian'); 
            $table->string('kode_bps');    
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bagian_fungsis');
    }
};
