<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MemorandumKeluar;
use App\Models\BagianFungsi;
use App\Models\KlasifikasiNaskah; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MemorandumKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = MemorandumKeluar::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nomor_naskah', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
        }

        $perPage = $request->input('per_page', 10);
        $memorandumKeluar = $query->orderBy('id', 'desc')->paginate($perPage);

        return view('memorandumkeluar.index', compact('memorandumKeluar'));
    }

    public function create()
    {
        $last = MemorandumKeluar::latest('id')->first();
        $nomorUrut = $last ? $last->id + 1 : 1;
        $bagianFungsi = BagianFungsi::all();
        $klasifikasiNaskah = KlasifikasiNaskah::all();

        return view('memorandumkeluar.create', compact('nomorUrut','bagianFungsi', 'klasifikasiNaskah'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nomor_urut'                => 'required',
                'bagian_fungsi_id'          => 'required|exists:bagian_fungsis,id',
                'klasifikasi_naskah_id'     => 'required|string',
                'perihal'                   => 'required|string',
                'tujuan_penerima'           => 'required|string',
                'tanggal'                   => 'required|date',
                'file'                      => 'nullable|mimes:pdf,doc,docx|max:2048', 
                'keterangan'                => 'nullable|string', 
            ]);

            $bagianFungsi = BagianFungsi::findOrFail($validated['bagian_fungsi_id']);
            $klasifikasiNaskah  = KlasifikasiNaskah::where('nama_klasifikasi', 'like', '%' . $request->klasifikasi_naskah_id . '%')
                ->orWhere('kode_klasifikasi', 'like', '%' . $request->klasifikasi_naskah_id . '%')
                ->firstOrFail();

            $nomorUrut = str_pad($validated['nomor_urut'], 2, '0', STR_PAD_LEFT);

            $nomorNaskah = $nomorUrut
                . '/' . $bagianFungsi->kode_bps
                . '/' . $klasifikasiNaskah->kode_klasifikasi
                . '/' . now()->year;

            $path = $request->hasFile('file')
                ? $request->file('file')->store('memorandum_keluar', 'public')
                : null;

            MemorandumKeluar::create([
                'nomor_naskah'          => $nomorNaskah,
                'bagian_fungsi_id'      => $bagianFungsi->id,
                'klasifikasi_naskah_id' => $klasifikasiNaskah->id,
                'perihal'               => $validated['perihal'],
                'tujuan_penerima'       => $validated['tujuan_penerima'],
                'tanggal'               => $validated['tanggal'],
                'file'                  => $path,
                'keterangan'            => $validated['keterangan'] ?? null, 
            ]);

            return redirect()->route('memorandum-keluar.index')->with('success', 'Memorandum berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }



    public function edit($id)
    {
        $memorandumKeluar = MemorandumKeluar::findOrFail($id);
        $bagianFungsi = BagianFungsi::all();
        $klasifikasiNaskah = KlasifikasiNaskah::all();

        return view('memorandumkeluar.edit', compact('memorandumKeluar', 'bagianFungsi', 'klasifikasiNaskah'));
    }

    public function update(Request $request, MemorandumKeluar $memorandumKeluar)
    {
        $request->validate([
            'bagian_fungsi_id'          => 'required|exists:bagian_fungsis,id',
            'klasifikasi_naskah_id'     => 'required|string',
            'perihal'                   => 'required|string|max:255',
            'tujuan_penerima'           => 'required|string|max:255',
            'tanggal'                   => 'required|date',
            'file'                      => 'nullable|mimes:pdf,doc,docx|max:2048', 
            'keterangan'                => 'nullable|string', 
        ]);

        try {
            DB::beginTransaction();

            $bagianFungsi = BagianFungsi::findOrFail($request->bagian_fungsi_id);
            $klasifikasiNaskah  = KlasifikasiNaskah::where('nama_klasifikasi', 'like', '%' . $request->klasifikasi_naskah_id . '%')
                ->orWhere('kode_klasifikasi', 'like', '%' . $request->klasifikasi_naskah_id . '%')
                ->firstOrFail();

            $oldNomorUrut = strtok($memorandumKeluar->nomor_naskah, '/');

            $nomorNaskah  = $oldNomorUrut
                . '/' . $bagianFungsi->kode_bps
                . '/' . $klasifikasiNaskah->kode_klasifikasi
                . '/' . now()->year;

            $data = [
                'bagian_fungsi_id'      => $bagianFungsi->id,
                'klasifikasi_naskah_id' => $klasifikasiNaskah->id,
                'perihal'               => $request->perihal,
                'tujuan_penerima'       => $request->tujuan_penerima,
                'tanggal'               => $request->tanggal,
                'keterangan'            => $request->keterangan ?? null, 
                'nomor_naskah'          => $nomorNaskah,
            ];

            if ($request->hasFile('file')) {
                if ($memorandumKeluar->file && Storage::disk('public')->exists($memorandumKeluar->file)) {
                    Storage::disk('public')->delete($memorandumKeluar->file);
                }
                $data['file'] = $request->file('file')->store('memorandum_keluar', 'public');
            }

            $memorandumKeluar->update($data);

            DB::commit();
            return redirect()->route('memorandum-keluar.index')->with('success', 'Memorandum berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }


    public function destroy(MemorandumKeluar $memorandumKeluar)
    {
        try {
            if ($memorandumKeluar->file && Storage::disk('public')->exists($memorandumKeluar->file)) {
                Storage::disk('public')->delete($memorandumKeluar->file);
            }

            $memorandumKeluar->delete();

            return redirect()->route('memorandum-keluar.index')->with('success', 'Memorandum berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
