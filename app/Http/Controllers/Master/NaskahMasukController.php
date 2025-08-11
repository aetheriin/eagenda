<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\NaskahMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NaskahMasukController extends Controller
{
    /**
     * Tampilkan daftar naskah masuk.
     */
    public function index(Request $request)
    {
        $query = NaskahMasuk::orderBy('id', 'desc');

        // ✅ Search berdasarkan nomor naskah atau perihal
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nomor_naskah', 'like', '%' . $request->search . '%')
                ->orWhere('perihal', 'like', '%' . $request->search . '%');
            });
        }

        // ✅ Filter jumlah data per halaman (default 10)
        $perPage = $request->get('per_page', 10);

        $naskahMasuk = $query->paginate($perPage)->appends([
            'search' => $request->search,
            'per_page' => $perPage
        ]);

        return view('naskahmasuk.index', compact('naskahMasuk'));
    }


    /**
     * Tampilkan form tambah.
     */
    public function create()
    {
        $last = NaskahMasuk::latest('id')->first();
        $nomorUrut = $last ? $last->id + 1 : 1;

        return view('naskahmasuk.create', compact('nomorUrut'));
    }

    /**
     * Simpan data baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_naskah' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'asal_pengirim' => 'required|string|max:255',
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

            $filePath = $request->file('file')->store('naskah_masuk', 'public');

            NaskahMasuk::create([
                'nomor_naskah' => $request->nomor_naskah,
                'perihal' => $request->perihal,
                'asal_pengirim' => $request->asal_pengirim,
                'tanggal' => $request->tanggal,
                'file' => $filePath,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();
            return redirect()->route('naskah-masuk.index')->with('success', 'Naskah masuk berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan form edit.
     */
    public function edit(NaskahMasuk $naskahMasuk)
    {
        return view('naskahmasuk.edit', compact('naskahMasuk'));
    }

    /**
     * Update data.
     */
    public function update(Request $request, NaskahMasuk $naskahMasuk)
    {
        $request->validate([
            'nomor_naskah' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'asal_pengirim' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['nomor_naskah', 'perihal', 'asal_pengirim', 'tanggal', 'keterangan']);

            if ($request->hasFile('file')) {
                if ($naskahMasuk->file && Storage::disk('public')->exists($naskahMasuk->file)) {
                    Storage::disk('public')->delete($naskahMasuk->file);
                }
                $data['file'] = $request->file('file')->store('naskah_masuk', 'public');
            }

            $naskahMasuk->update($data);

            DB::commit();
            return redirect()->route('naskah-masuk.index')->with('success', 'Naskah masuk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }

    /**
     * Hapus data.
     */
    public function destroy(NaskahMasuk $naskahMasuk)
    {
        try {
            if ($naskahMasuk->file && Storage::disk('public')->exists($naskahMasuk->file)) {
                Storage::disk('public')->delete($naskahMasuk->file);
            }

            $naskahMasuk->delete();

            return redirect()->route('naskah-masuk.index')->with('success', 'Naskah masuk berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
