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
        'bagian_fungsi',
        'klasifikasi',
        'perihal',
        'tujuan_penerima',
        'tanggal',
        'file',
        'keterangan',
    ];
}
