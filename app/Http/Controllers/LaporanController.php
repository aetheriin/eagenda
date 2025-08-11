<?php

namespace App\Http\Controllers;

use App\Models\MemorandumKeluar;
use App\Models\NaskahMasuk;

class LaporanController extends Controller
{
    public function ringkasan()
    {
        $year = session('tahun_selected', now()->year);
        $keluar = MemorandumKeluar::whereYear('tanggal', $year)->count();
        $masuk = NaskahMasuk::whereYear('tanggal', $year)->count();
        return view('laporan.ringkasan', compact('year', 'keluar', 'masuk'));
    }

    public function export()
    {
        // Placeholder: nanti bisa dipakai generate CSV/PDF
        return view('laporan.export');
    }

    public function filter()
    {
        // Placeholder filter form
        return view('laporan.filter');
    }
}
