<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BagianFungsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BagianFungsiController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $query = BagianFungsi::orderBy('id', 'desc');

        // ✅ Search berdasarkan nomor naskah atau perihal
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('kode_bps', 'like', '%' . $request->search . '%')
                ->orWhere('nama_bagian', 'like', '%' . $request->search . '%');
            });
        }

        // ✅ Filter jumlah data per halaman (default 10)
        $perPage = $request->get('per_page', 10);

        $bagianFungsi = $query->paginate($perPage)->appends([
            'search' => $request->search,
            'per_page' => $perPage
        ]);

        return view('bagianfungsi.index', compact('bagianFungsi'));
    }


    /**
     * Tampilkan form tambah.
     */
    public function create()
    {
        $last = BagianFungsi::latest('id')->first();
        $nomorUrut = $last ? $last->id + 1 : 1;

        return view('bagianfungsi.create', compact('nomorUrut'));
    }

    /**
     * Simpan data baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_bps' => 'required|string|max:255',
            'nama_bagian' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            BagianFungsi::create([
                'kode_bps' => $request->kode_bps,
                'nama_bagian' => $request->nama_bagian,
            ]);

            DB::commit();
            return redirect()->route('bagian-fungsi.index')->with('success', 'Bagian/Fungsi berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan form edit.
     */
    public function edit(BagianFungsi $bagianFungsi)
    {
        return view('bagianfungsi.edit', compact('bagianFungsi'));
    }

    /**
     * Update data.
     */
    public function update(Request $request, BagianFungsi $bagianFungsi)
    {
        $request->validate([
            'kode_bps' => 'required|string|max:255',
            'nama_bagian' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['kode_bps', 'nama_bagian']);
            $bagianFungsi->update($data);

            DB::commit();
            return redirect()->route('bagian-fungsi.index')->with('success', 'Bagian/Fungsi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }


    /**
     * Hapus data.
     */
    public function destroy(BagianFungsi $bagianFungsi)
    {
        try {
            if ($bagianFungsi->file && Storage::disk('public')->exists($bagianFungsi->file)) {
                Storage::disk('public')->delete($bagianFungsi->file);
            }

            $bagianFungsi->delete();

            return redirect()->route('bagian-fungsi.index')->with('success', 'Bagian/Fungsi berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }

    
}
