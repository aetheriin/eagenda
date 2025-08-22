<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiNaskah extends Model
{
    use HasFactory;

    protected $table = 'klasifikasi_naskahs';

    protected $fillable = [
        'nama_klasifikasi',   // contoh: "PERENCANAAN"
        'kode_klasifikasi',   // contoh: "SS.000"
    ];

    // 🔗 Relasi ke MemorandumKeluar
    public function memorandumKeluar()
    {
        return $this->hasMany(MemorandumKeluar::class);
    }
}
