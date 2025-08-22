<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtim extends Model
{
    use HasFactory;

    // Nama tabel (opsional, karena Laravel otomatis plural dari nama model)
    protected $table = 'sub_tims';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nama_subtim',
        'kode_subtim',
    ];
}
