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
        'bagian_fungsi',
        'klasifikasi',
        'perihal',
        'tujuan_penerima',
        'tanggal',
        'file',
        'keterangan',
    ];
}

