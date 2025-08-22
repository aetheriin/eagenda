<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BelanjaKeluar;
use App\Models\BagianFungsi;
use App\Models\KlasifikasiNaskah; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BelanjaKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = BelanjaKeluar::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nomor_naskah', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
        }

        $perPage = $request->input('per_page', 10);
        $belanjaKeluar = $query->orderBy('id', 'desc')->paginate($perPage);

        return view('belanjakeluar.index', compact('belanjaKeluar'));
    }

    public function create()
    {
        $last = BelanjaKeluar::latest('id')->first();
        $nomorUrut = $last ? $last->id + 1 : 1;
        $bagianFungsi = BagianFungsi::all();

        return view('belanjakeluar.create', compact('nomorUrut','bagianFungsi'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nomor_urut'       => 'required',
                'bagian_fungsi_id' => 'required|exists:bagian_fungsis,id',
                'klasifikasi'      => 'required|exists:klasifikasi_naskahs,nama_klasifikasi',
                'perihal'          => 'required|string',
                'tujuan_penerima'  => 'required|string',
                'tanggal'          => 'required|date',
                'file'             => 'nullable|mimes:pdf,doc,docx|max:2048', // ✅ tidak wajib
                'keterangan'       => 'nullable|string', // ✅ tidak wajib
            ]);

            $bagianFungsi = BagianFungsi::findOrFail($validated['bagian_fungsi_id']);
            $klasifikasi  = KlasifikasiNaskah::where('nama_klasifikasi', $validated['klasifikasi'])->firstOrFail();
            $nomorUrut = str_pad($validated['nomor_urut'], 2, '0', STR_PAD_LEFT);

            $nomorNaskah = $nomorUrut
                . '/' . $bagianFungsi->kode_bps
                . '/' . $klasifikasi->kode_klasifikasi
                . '/' . now()->year;

            // jika ada file baru → simpan, kalau tidak null
            $path = $request->hasFile('file') 
                ? $request->file('file')->store('belanja', 'public') 
                : null;

            BelanjaKeluar::create([
                'nomor_naskah'          => $nomorNaskah,
                'bagian_fungsi_id'      => $bagianFungsi->id,
                'klasifikasi_naskah_id' => $klasifikasi->id,
                'perihal'               => $validated['perihal'],
                'tujuan_penerima'       => $validated['tujuan_penerima'],
                'tanggal'               => $validated['tanggal'],
                'file'                  => $path,
                'keterangan'            => $validated['keterangan'] ?? null, // kalau kosong → null
            ]);

            return redirect()->route('belanja-keluar.index')->with('success', 'Belanja Keluar berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }



    public function edit($id)
    {
        $belanjaKeluar = BelanjaKeluar::findOrFail($id);
        $bagianFungsi = BagianFungsi::all();

        return view('belanjakeluar.edit', compact('belanjaKeluar', 'bagianFungsi'));
    }

    public function update(Request $request, BelanjaKeluar $belanjaKeluar)
    {
        $request->validate([
            'bagian_fungsi_id' => 'required|exists:bagian_fungsis,id',
            'klasifikasi'      => 'required|exists:klasifikasi_naskahs,nama_klasifikasi',
            'perihal'          => 'required|string|max:255',
            'tujuan_penerima'  => 'required|string|max:255',
            'tanggal'          => 'required|date',
            'file'             => 'nullable|mimes:pdf,doc,docx|max:2048', 
            'keterangan'       => 'nullable|string', 
        ]);

        try {
            DB::beginTransaction();

            $bagianFungsi = BagianFungsi::findOrFail($request->bagian_fungsi_id);
            $klasifikasi  = KlasifikasiNaskah::where('nama_klasifikasi', $request->klasifikasi)->firstOrFail();

            $oldNomorUrut = strtok($belanjaKeluar->nomor_naskah, '/');
            $nomorNaskah  = $oldNomorUrut
                . '/' . $bagianFungsi->kode_bps
                . '/' . $klasifikasi->kode_klasifikasi
                . '/' . now()->year;

            $data = [
                'bagian_fungsi_id'      => $bagianFungsi->id,
                'klasifikasi_naskah_id' => $klasifikasi->id,
                'perihal'               => $request->perihal,
                'tujuan_penerima'       => $request->tujuan_penerima,
                'tanggal'               => $request->tanggal,
                'keterangan'            => $request->keterangan ?? null, 
                'nomor_naskah'          => $nomorNaskah,
            ];

            if ($request->hasFile('file')) {
                if ($belanjaKeluar->file && Storage::disk('public')->exists($belanjaKeluar->file)) {
                    Storage::disk('public')->delete($belanjaKeluar->file);
                }
                $data['file'] = $request->file('file')->store('belanja', 'public');
            }

            $belanjaKeluar->update($data);

            DB::commit();
            return redirect()->route('belanja-keluar.index')->with('success', 'Belanja berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }




    public function destroy(BelanjaKeluar $belanjaKeluar)
    {
        try {
            if ($belanjaKeluar->file && Storage::disk('public')->exists($belanjaKeluar->file)) {
                Storage::disk('public')->delete($belanjaKeluar->file);
            }

            $belanjaKeluar->delete();

            return redirect()->route('belanja-keluar.index')->with('success', 'Belanja berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
