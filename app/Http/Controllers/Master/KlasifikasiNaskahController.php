<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\KlasifikasiNaskah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KlasifikasiNaskahController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $query = KlasifikasiNaskah::orderBy('id', 'desc');

        // ✅ Search berdasarkan nomor kode atau nama
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('kode', 'like', '%' . $request->search . '%')
                ->orWhere('nama', 'like', '%' . $request->search . '%');
            });
        }

        // ✅ Filter jumlah data per halaman (default 10)
        $perPage = $request->get('per_page', 10);

        $klasifikasiNaskah = $query->paginate($perPage)->appends([
            'search' => $request->search,
            'per_page' => $perPage
        ]);

        return view('klasifikasinaskah.index', compact('klasifikasiNaskah'));
    }


    /**
     * Tampilkan form tambah.
     */
    public function create()
    {
        $last = KlasifikasiNaskah::latest('id')->first();
        $nomorUrut = $last ? $last->id + 1 : 1;

        return view('klasifikasinaskah.create', compact('nomorUrut'));
    }

    /**
     * Simpan data baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            KlasifikasiNaskah::create([
                'kode' => $request->kode,
                'nama' => $request->nama,
            ]);

            DB::commit();
            return redirect()->route('klasifikasi-naskah.index')->with('success', 'Klasifikasi Naskah berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan form edit.
     */
    public function edit(KlasifikasiNaskah $klasifikasiNaskah)
    {
        return view('klasifikasinaskah.edit', compact('klasifikasiNaskah'));
    }

    /**
     * Update data.
     */
    public function update(Request $request, KlasifikasiNaskah $klasifikasiNaskah)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['kode', 'nama']);
            $klasifikasiNaskah->update($data);

            DB::commit();
            return redirect()->route('klasifikasi-naskah.index')->with('success', 'Klasifikasi Naskah berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }


    /**
     * Hapus data.
     */
    public function destroy(KlasifikasiNaskah $klasifikasiNaskah)
    {
        try {
            if ($klasifikasiNaskah->file && Storage::disk('public')->exists($klasifikasiNaskah->file)) {
                Storage::disk('public')->delete($klasifikasiNaskah->file);
            }

            $klasifikasiNaskah->delete();

            return redirect()->route('klasifikasi-naskah.index')->with('success', 'Klasifikasi Naskah berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }

    
}
