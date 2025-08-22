<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\KeamananSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KeamananSuratController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $query = KeamananSurat::orderBy('id', 'desc');

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('kode', 'like', '%' . $request->search . '%')
                ->orWhere('nama', 'like', '%' . $request->search . '%');
            });
        }

        $perPage = $request->get('per_page', 10);

        $keamananSurat = $query->paginate($perPage)->appends([
            'search' => $request->search,
            'per_page' => $perPage
        ]);

        return view('keamanansurat.index', compact('keamananSurat'));
    }


    /**
     * Tampilkan form tambah.
     */
    public function create()
    {
        $last = KeamananSurat::latest('id')->first();
        $nomorUrut = $last ? $last->id + 1 : 1;

        return view('keamanansurat.create', compact('nomorUrut'));
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

            KeamananSurat::create([
                'kode' => $request->kode,
                'nama' => $request->nama,
            ]);

            DB::commit();
            return redirect()->route('keamanan-surat.index')->with('success', 'Keamanan Surat berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan form edit.
     */
    public function edit(KeamananSurat $keamananSurat)
    {
        return view('keamanansurat.edit', compact('keamananSurat'));
    }

    /**
     * Update data.
     */
    public function update(Request $request, KeamananSurat $keamananSurat)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['kode', 'nama']);
            $keamananSurat->update($data);

            DB::commit();
            return redirect()->route('keamanan-surat.index')->with('success', 'Keamanan Surat berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }


    /**
     * Hapus data.
     */
    public function destroy(KeamananSurat $keamananSurat)
    {
        try {
            if ($keamananSurat->file && Storage::disk('public')->exists($keamananSurat->file)) {
                Storage::disk('public')->delete($keamananSurat->file);
            }

            $keamananSurat->delete();

            return redirect()->route('keamanan-surat.index')->with('success', 'Keamanan Surat berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }

    
}
