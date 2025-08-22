<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BelanjaKeluar extends Model
{
    use HasFactory;

    protected $table = 'belanja_keluars';

    protected $fillable = [
        'nomor_naskah',         
        'bagian_fungsi_id',     
        'klasifikasi_naskah_id',
        'perihal',
        'tujuan_penerima',
        'tanggal',
        'file',
        'keterangan',
    ];

    // 🔗 Relasi ke BagianFungsi
    public function bagianFungsi()
    {
        return $this->belongsTo(BagianFungsi::class);
    }

    // 🔗 Relasi ke KlasifikasiNaskah
    public function klasifikasiNaskah()
    {
        return $this->belongsTo(KlasifikasiNaskah::class);
    }
}
