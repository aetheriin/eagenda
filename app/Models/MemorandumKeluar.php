<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemorandumKeluar extends Model
{
    use HasFactory;

    protected $table = 'memorandum_keluars';

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

    public function bagianFungsi()
    {
        return $this->belongsTo(BagianFungsi::class);
    }

    public function klasifikasiNaskah()
    {
        return $this->belongsTo(KlasifikasiNaskah::class);
    }
}
