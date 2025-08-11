<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiNaskah extends Model
{
    use HasFactory;

    protected $table = 'klasifikasi_naskahs';

    protected $fillable = [
        'kode',
        'nama',
    ];
}
