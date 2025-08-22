<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NaskahMasuk;
use App\Models\MemorandumKeluar;
use App\Models\BelanjaKeluar;
use App\Models\SuratTugas;
use App\Models\SuratDinas;
use App\Models\UndanganInternal;
use App\Models\UndanganEksternal;
use App\Models\SopKeluar;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $selectedYear = session('tahun_selected', now()->year);

        // Total Masuk & Total User
        $totalMasuk = NaskahMasuk::whereYear('created_at', $selectedYear)->count();
        $totalUser = User::count();

        // Definisikan semua model keluar beserta labelnya
        $models = [
            'Memorandum Keluar' => MemorandumKeluar::class,
            'Belanja Keluar' => BelanjaKeluar::class,
            'Surat Tugas' => SuratTugas::class,
            'Surat Dinas' => SuratDinas::class,
            'Undangan Internal' => UndanganInternal::class,
            'Undangan Eksternal' => UndanganEksternal::class,
            'SOP Keluar' => SopKeluar::class,
        ];

        $naskahKeluarByJenis = [];

        $totalKeluar = 0;

        foreach ($models as $label => $model) {
            $count = $model::whereYear('created_at', $selectedYear)->count();
            $naskahKeluarByJenis[] = [
                'jenis' => $label,
                'jumlah' => $count,
            ];
            $totalKeluar += $count;
        }

        return view('dashboard', compact('selectedYear', 'totalMasuk', 'totalKeluar', 'totalUser', 'naskahKeluarByJenis'));
    }
}
