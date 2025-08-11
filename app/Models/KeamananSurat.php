<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeamananSurat extends Model
{
    use HasFactory;

    protected $table = 'keamanan_surats';

    protected $fillable = [
        'kode',
        'nama',
    ];
}
