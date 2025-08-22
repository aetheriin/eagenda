<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    use HasFactory;

    protected $table = 'surat_tugas';

    protected $fillable = [
        'nomor_naskah',
        'keamanan_surat_id',
        'bagian_fungsi_id',     
        'klasifikasi_naskah_id',
        'perihal',
        'tujuan_penerima',
        'tanggal',
        'file',
        'keterangan',
    ];

    public function keamananSurat()
    {
        return $this->belongsTo(KeamananSurat::class );
    }

    public function bagianFungsi()
    {
        return $this->belongsTo(BagianFungsi::class);
    }

    public function klasifikasiNaskah()
    {
        return $this->belongsTo(KlasifikasiNaskah::class);
    }
}
