<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BagianFungsi extends Model
{
    use HasFactory;

    protected $table = 'bagian_fungsis';

    protected $fillable = [
        'nama_bagian',   // contoh: "BPS Provinsi Riau"
        'kode_bps',      // contoh: "12.07"
    ];

    // 🔗 Relasi ke MemorandumKeluar
    public function memorandumKeluar()
    {
        return $this->hasMany(MemorandumKeluar::class);
    }
}
