<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;
use App\Models\NaskahMasuk;
use App\Models\MemorandumKeluar;
use App\Models\BelanjaKeluar;
use App\Models\SopKeluar;
use App\Models\SuratTugas;
use App\Models\SuratDinas;
use App\Models\UndanganInternal;
use App\Models\UndanganEksternal;

class LaporanController extends Controller
{
    // Naskah Masuk
    public function naskahMasuk()
    {
        return view('laporan.naskahmasuk');
    }

    public function exportNaskahMasuk(Request $request)
    {
        // Validasi input biar aman
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $start = $request->start_date;
        $end   = $request->end_date;

        // Ambil data sesuai range tanggal surat (BUKAN created_at)
        $data = NaskahMasuk::whereBetween('tanggal', [$start, $end])
            ->get(['id','nomor_naskah','asal_pengirim','perihal','tanggal','created_at']);

        $headings = ['ID','Nomor Naskah','Asal Pengirim','Perihal','Tanggal Surat','Created At'];

        return Excel::download(new GenericExport($data, $headings), "laporan-naskah-masuk-{$start}-sd-{$end}.xlsx");
    }


    // Naskah Keluar
    public function naskahKeluar()
    {
        
        $memorandumKeluar    = MemorandumKeluar::latest()->take(5)->get();
        $belanjaKeluar       = BelanjaKeluar::latest()->take(5)->get();
        $suratTugas          = SuratTugas::latest()->take(5)->get();
        $suratDinas          = SuratDinas::latest()->take(5)->get();
        $undanganInternal    = UndanganInternal::latest()->take(5)->get();
        $undanganEksternal   = UndanganEksternal::latest()->take(5)->get();
        $sopKeluar           = SopKeluar::latest()->take(5)->get();

        return view('laporan.naskahkeluar', compact(
            'memorandumKeluar','belanjaKeluar','suratTugas','suratDinas',
            'undanganInternal','undanganEksternal','sopKeluar'
        ));
    }

    // Export naskah keluar
    public function exportNaskahKeluar(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $start = $request->start_date;
        $end   = $request->end_date;
        $jenis = $request->jenis; 

        $data = collect();
        $fileName = 'laporan.xlsx';
        $defaultHeadings = []; 

        switch($jenis) {
            case 'memorandum-keluar':
                $data = MemorandumKeluar::whereBetween('tanggal', [$start, $end])
                    ->get(['id','nomor_naskah','bagian_fungsi_id','klasifikasi_naskah_id','perihal','tujuan_penerima','tanggal','file','keterangan','created_at']);
                $fileName = 'laporan-memorandum-keluar.xlsx';
                $defaultHeadings = ['ID','Nomor Naskah','Bagian Fungsi ','Klasifikasi Naskah ','Perihal','Tujuan Penerima','Tanggal','File','Keterangan','Created At'];
                break;

            case 'belanja-keluar':
                $data = BelanjaKeluar::whereBetween('tanggal', [$start, $end])
                    ->get(['id','nomor_naskah','bagian_fungsi_id','klasifikasi_naskah_id','perihal','tujuan_penerima','tanggal','file','keterangan','created_at']);
                $fileName = 'laporan-belanja-keluar.xlsx';
                $defaultHeadings = ['ID','Nomor Naskah','Bagian Fungsi','Klasifikasi Naskah','Perihal','Tujuan Penerima','Tanggal','File','Keterangan','Created At'];
                break;

            case 'surat-tugas':
                $data = SuratTugas::whereBetween('tanggal', [$start, $end])
                    ->get(['id','nomor_naskah','keamanan_surat_id','bagian_fungsi_id','klasifikasi_naskah_id','perihal','tujuan_penerima','tanggal','file','keterangan','created_at']);
                $fileName = 'laporan-surat-tugas.xlsx';
                $defaultHeadings = ['ID','Nomor Naskah','Keamanan Surat','Bagian Fungsi','Klasifikasi Naskah','Perihal','Tujuan Penerima','Tanggal','File','Keterangan','Created At'];
                break;

            case 'surat-dinas':
                $data = SuratDinas::whereBetween('tanggal', [$start, $end])
                    ->get(['id','nomor_naskah','keamanan_surat_id','bagian_fungsi_id','klasifikasi_naskah_id','perihal','tujuan_penerima','tanggal','file','keterangan','created_at']);
                $fileName = 'laporan-surat-dinas.xlsx';
                $defaultHeadings = ['ID','Nomor Naskah','Keamanan Surat','Bagian Fungsi','Klasifikasi Naskah','Perihal','Tujuan Penerima','Tanggal','File','Keterangan','Created At'];
                break;

            case 'undangan-internal':
                $data = UndanganInternal::whereBetween('tanggal', [$start, $end])
                    ->get(['id','nomor_naskah','keamanan_surat_id','bagian_fungsi_id','klasifikasi_naskah_id','perihal','tujuan_penerima','tanggal','file','keterangan','created_at']);
                $fileName = 'laporan-undangan-internal.xlsx';
                $defaultHeadings = ['ID','Nomor Naskah','Keamanan Surat','Bagian Fungsi','Klasifikasi Naskah','Perihal','Tujuan Penerima','Tanggal','File','Keterangan','Created At'];
                break;

            case 'undangan-eksternal':
                $data = UndanganEksternal::whereBetween('tanggal', [$start, $end])
                    ->get(['id','nomor_naskah','keamanan_surat_id','bagian_fungsi_id','klasifikasi_naskah_id','perihal','tujuan_penerima','tanggal','file','keterangan','created_at']);
                $fileName = 'laporan-undangan-eksternal.xlsx';
                $defaultHeadings = ['ID','Nomor Naskah','Keamanan Surat','Bagian Fungsi','Klasifikasi Naskah ','Perihal','Tujuan Penerima','Tanggal','File','Keterangan','Created At'];
                break;

            case 'sop-keluar':
                $data = SopKeluar::whereBetween('tanggal_dibuat', [$start, $end])
                    ->get(['id','nomor_naskah','sub_tim_id','nama_sop','tanggal_dibuat','tanggal_berlaku','file','keterangan','created_at']);
                $fileName = 'laporan-sop-keluar.xlsx';
                $defaultHeadings = ['ID','Nomor Naskah','Sub Tim ','Nama SOP','Tanggal Dibuat','Tanggal Berlaku','File','Keterangan','Created At'];
                break;

            default:
                return back()->with('error', 'Jenis laporan tidak valid!');
        }

        return Excel::download(new GenericExport($data, $defaultHeadings), $fileName);
    }
}
