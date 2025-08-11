<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MemorandumKeluar;
use App\Models\BagianFungsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MemorandumKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = MemorandumKeluar::query();

        // Logika pencarian
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nomor_naskah', 'like', "%{$search}%")
                ->orWhere('perihal', 'like', "%{$search}%");
        }

        // Jumlah data per halaman
        $perPage = $request->input('per_page', 10);

        $memorandumKeluar = $query->orderBy('id', 'desc')->paginate($perPage);

        return view('memorandumkeluar.index', compact('memorandumKeluar'));
    }


    public function create()
    {
        $last = MemorandumKeluar::latest('id')->first();
        $nomorUrut = $last ? $last->id + 1 : 1;
        $bagianFungsi = BagianFungsi::all();

        return view('memorandumkeluar.create', compact('nomorUrut','bagianFungsi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_naskah' => 'required|string|max:255',
            'bagian_fungsi' => 'required|string|max:255',
            'klasifikasi' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tujuan_penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'required|string',
        ], [
            'required' => ':attribute wajib diisi.',
            'mimes' => 'File harus berupa PDF atau Word.',
            'max' => 'Ukuran file maksimal 2MB.',
        ]);

        try {
            DB::beginTransaction();

            $filePath = $request->file('file')->store('memorandum_keluar', 'public');

            MemorandumKeluar::create([
                'nomor_naskah' => $request->nomor_naskah,
                'bagian_fungsi' => $request->bagian_fungsi,
                'klasifikasi' => $request->klasifikasi,
                'perihal' => $request->perihal,
                'tujuan_penerima' => $request->tujuan_penerima,
                'tanggal' => $request->tanggal,
                'file' => $filePath,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();
            return redirect()->route('memorandum-keluar.index')->with('success', 'Memorandum berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $memorandumKeluar = MemorandumKeluar::findOrFail($id);
        $bagianFungsi = BagianFungsi::all();

        return view('memorandumkeluar.edit', compact('memorandumKeluar', 'bagianFungsi'));
    }


    public function update(Request $request, MemorandumKeluar $memorandumKeluar)
    {
        $request->validate([
            'nomor_naskah' => 'required|string|max:255',
            'bagian_fungsi' => 'required|string|max:255',
            'klasifikasi' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tujuan_penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['nomor_naskah', 'bagian_fungsi', 'klasifikasi', 'perihal', 'tujuan_penerima', 'tanggal', 'keterangan']);

            if ($request->hasFile('file')) {
                if ($memorandumKeluar->file && Storage::disk('public')->exists($memorandumKeluar->file)) {
                    Storage::disk('public')->delete($memorandumKeluar->file);
                }
                $data['file'] = $request->file('file')->store('naskah_masuk', 'public');
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
