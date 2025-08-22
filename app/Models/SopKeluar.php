<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SopKeluar extends Model
{
    use HasFactory;

    protected $table = 'sop_keluars';

    protected $fillable = [
        'nomor_naskah', 
        'sub_tim_id',
        'nama_sop',
        'tanggal_dibuat',
        'tanggal_berlaku',
        'file',
        'keterangan',
    ];

    public function subTim()
    {
        return $this->belongsTo(SubTim::class);
    }
}
