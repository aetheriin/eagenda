<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SubTim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubTimController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $query = SubTim::orderBy('id', 'desc');

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('kode_subtim', 'like', '%' . $request->search . '%')
                ->orWhere('nama_subtim', 'like', '%' . $request->search . '%');
            });
        }

        $perPage = $request->get('per_page', 10);

        $subTim = $query->paginate($perPage)->appends([
            'search' => $request->search,
            'per_page' => $perPage
        ]);

        return view('subtim.index', compact('subTim'));
    }


    /**
     * Tampilkan form tambah.
     */
    public function create()
    {
        $last = SubTim::latest('id')->first();
        $nomorUrut = $last ? $last->id + 1 : 1;

        return view('subtim.create', compact('nomorUrut'));
    }

    /**
     * Simpan data baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_subtim' => 'required|string|max:255',
            'nama_subtim' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            SubTim::create([
                'kode_subtim' => $request->kode_subtim,
                'nama_subtim' => $request->nama_subtim,
            ]);

            DB::commit();
            return redirect()->route('profile.admin')->with('success', 'Sub Tim berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan form edit.
     */
    public function edit(SubTim $subTim)
    {
        return view('subtim.edit', compact('subtim'));
    }

    /**
     * Update data.
     */
    public function update(Request $request, SubTim $subTim)
    {
        $request->validate([
            'kode_subtim' => 'required|string|max:255',
            'nama_subtim' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['kode_subtim', 'nama_subtim']);
            $subTim->update($data);

            DB::commit();
            return redirect()->route('profile.admin')->with('success', 'Sub Tim berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }


    /**
     * Hapus data.
     */
    public function destroy(SubTim $subTim)
    {
        try {
            if ($subTim->file && Storage::disk('public')->exists($subTim->file)) {
                Storage::disk('public')->delete($subTim->file);
            }

            $subTim->delete();

            return redirect()->route('profile.admin')->with('success', 'Sub Tim berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }

    
}
