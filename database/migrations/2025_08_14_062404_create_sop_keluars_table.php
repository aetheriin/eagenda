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
        Schema::create('sop_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_naskah');

            $table->foreignId('sub_tim_id')
                  ->constrained('sub_tims')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
                  
            $table->string('nama_sop');
            $table->string('tanggal_dibuat');
            $table->string('tanggal_berlaku');
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
        Schema::dropIfExists('sop_keluars');
    }
};
