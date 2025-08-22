<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\UndanganInternal;
use App\Models\KeamananSurat;
use App\Models\BagianFungsi;
use App\Models\KlasifikasiNaskah; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UndanganInternalController extends Controller
{
    public function index(Request $request)
    {
        $query = UndanganInternal::with(['keamananSurat']);

        // Pencarian
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nomor_naskah', 'like', "%{$search}%")
                ->orWhere('perihal', 'like', "%{$search}%");
        }

        $perPage = $request->input('per_page', 10);
        $undanganInternal = $query->orderBy('id', 'desc')->paginate($perPage);

        return view('undanganinternal.index', compact('undanganInternal'));
    }

    public function create()
    {
        $last = UndanganInternal::latest('id')->first();
        $nomorUrut = $last ? $last->id + 1 : 1;
        $bagianFungsi = BagianFungsi::all();
        $keamananSurat = KeamananSurat::all();

        return view('undanganinternal.create', compact('nomorUrut', 'bagianFungsi', 'keamananSurat'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nomor_urut'       => 'required',
                'keamanan_surat_id'=> 'required|exists:keamanan_surats,id',
                'bagian_fungsi_id' => 'required|exists:bagian_fungsis,id',
                'klasifikasi'      => 'required|string',
                'perihal'          => 'required|string',
                'tujuan_penerima'  => 'required|string',
                'tanggal'          => 'required|date',
                'file'             => 'nullable|mimes:pdf,doc,docx|max:2048',
                'keterangan'       => 'nullable|string',
            ]);

            $bagianFungsi = BagianFungsi::findOrFail($validated['bagian_fungsi_id']);
            $klasifikasi  = KlasifikasiNaskah::where('nama_klasifikasi', 'like', '%' . $request->klasifikasi . '%')
                ->orWhere('kode_klasifikasi', 'like', '%' . $request->klasifikasi . '%')
                ->firstOrFail();
            $nomorUrut = str_pad($validated['nomor_urut'], 2, '0', STR_PAD_LEFT);
            
            $nomorNaskah = 'B-'.$nomorUrut
                . '/' . $bagianFungsi->kode_bps
                . '/' . $klasifikasi->kode_klasifikasi
                . '/' . now()->year;

            $path = $request->file('file')->store('belanja', 'public');

            UndanganInternal::create([
                'nomor_naskah'          => $nomorNaskah,
                'keamanan_surat_id'     => $request->keamanan_surat_id,
                'bagian_fungsi_id'      => $bagianFungsi->id,
                'klasifikasi_naskah_id' => $klasifikasi->id, 
                'perihal'               => $validated['perihal'],
                'tujuan_penerima'       => $validated['tujuan_penerima'],
                'tanggal'               => $validated['tanggal'],
                'file'                  => $path,
                'keterangan'            => $validated['keterangan'],
            ]);

            return redirect()->route('undangan-internal.index')->with('success', 'Undangan Internal berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $undanganInternal = UndanganInternal::findOrFail($id);
        $bagianFungsi = BagianFungsi::all();
        $keamananSurat = KeamananSurat::all();

        return view('undanganinternal.edit', compact('undanganInternal', 'bagianFungsi', 'keamananSurat'));
    }

    public function update(Request $request, UndanganInternal $undanganInternal)
    {
        $request->validate([
            'keamanan_surat_id' => 'required|exists:keamanan_surats,id',
            'bagian_fungsi_id' => 'required|exists:bagian_fungsis,id',
            'klasifikasi'      => 'required|string',
            'perihal' => 'required|string|max:255',
            'tujuan_penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $bagianFungsi = BagianFungsi::findOrFail($request->bagian_fungsi_id);
        $klasifikasi  = KlasifikasiNaskah::where('nama_klasifikasi', 'like', '%' . $request->klasifikasi . '%')
            ->orWhere('kode_klasifikasi', 'like', '%' . $request->klasifikasi . '%')
            ->firstOrFail();

            $oldNomorUrut = strtok($undanganInternal->nomor_naskah, '/');

            $nomorNaskah  = $oldNomorUrut
                . '/' . $bagianFungsi->kode_bps
                . '/' . $klasifikasi->kode_klasifikasi
                . '/' . now()->year;

            $data = [
                'keamanan_surat_id'     => $keamananSurat->id,
                'bagian_fungsi_id'      => $bagianFungsi->id,
                'klasifikasi_naskah_id' => $klasifikasi->id, 
                'perihal'               => $request->perihal,
                'tujuan_penerima'       => $request->tujuan_penerima,
                'tanggal'               => $request->tanggal,
                'keterangan'            => $request->keterangan,
                'nomor_naskah'          => $nomorNaskah,
            ];

            if ($request->hasFile('file')) {
                if ($undanganInternal->file && Storage::disk('public')->exists($undanganInternal->file)) {
                    Storage::disk('public')->delete($undanganInternal->file);
                }
                $data['file'] = $request->file('file')->store('surat', 'public');
            }

            $undanganInternal->update($data);

            DB::commit();
            return redirect()->route('undangan-internal.index')->with('success', 'Undangan Internal berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }

    public function destroy(UndanganInternal $undanganInternal)
    {
        try {
            if ($undanganInternal->file && Storage::disk('public')->exists($undanganInternal->file)) {
                Storage::disk('public')->delete($undanganInternal->file);
            }

            $undanganInternal->delete();

            return redirect()->route('undangan-internal.index')->with('success', 'Undangan Internal berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
