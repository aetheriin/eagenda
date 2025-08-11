<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NaskahMasuk extends Model
{
    use HasFactory;

    protected $table = 'naskah_masuks';

    protected $fillable = [
        'nomor_naskah',
        'perihal',
        'asal_pengirim',
        'tanggal',
        'file',
        'keterangan'
    ];
}

