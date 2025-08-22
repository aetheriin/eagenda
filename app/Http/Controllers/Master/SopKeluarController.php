<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SopKeluar;
use App\Models\Subtim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SopKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = SopKeluar::query();

        // Logika pencarian
        // if ($request->has('search')) {
        //     $search = $request->input('search');
        //     $query->where('nomor_naskah', 'like', "%{$search}%")
        //         ->orWhere('perihal', 'like', "%{$search}%");
        // }

        // Jumlah data per halaman
        $perPage = $request->input('per_page', 10);

        $sopKeluar = $query->orderBy('id', 'desc')->paginate($perPage);

        return view('sopkeluar.index', compact('sopKeluar'));
    }


    public function create()
    {
        $last = SopKeluar::latest('id')->first();
        $nomorUrut = $last ? $last->id + 1 : 1;
        $subTim = SubTim::all();

        return view('sopkeluar.create', compact('nomorUrut','subTim'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nomor_urut'      => 'required',
                'sub_tim_id'      => 'required|exists:sub_tims,id',
                'nama_sop'        => 'required|string|max:255',
                'tanggal_dibuat'  => 'required|date',
                'tanggal_berlaku' => 'required|date',
                'file'            => 'required|mimes:pdf,doc,docx|max:2048',
                'keterangan'      => 'required|string',
            ]);

            $subTim = SubTim::findOrFail($validated['sub_tim_id']);

            $nomorUrut = str_pad($validated['nomor_urut'], 2, '0', STR_PAD_LEFT);

            $nomorNaskah = 'SOP-' . $nomorUrut
                . '/' . $subTim->kode_subtim
                . '/' . now()->year;

            
            $filePath = $request->file('file')->store('sop_keluar', 'public');

            SopKeluar::create([
                'nomor_naskah' => $nomorNaskah,
                'sub_tim_id'   => $validated['sub_tim_id'],
                'nama_sop'     => $validated['nama_sop'],
                'tanggal_dibuat'  => $validated['tanggal_dibuat'],
                'tanggal_berlaku' => $validated['tanggal_berlaku'],
                'file'         => $filePath,
                'keterangan'   => $validated['keterangan'],
            ]);

            return redirect()->route('sop-keluar.index')->with('success', 'SOP Keluar berhasil ditambahkan!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Error lain
            return back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage())->withInput();
        }
    }


    public function edit($id)
    {
        $sopKeluar = SopKeluar::findOrFail($id);
        $subTim = SubTim::all();

        return view('sopkeluar.edit', compact('sopKeluar', 'subTim'));
    }


    public function update(Request $request, SopKeluar $sopKeluar)
    {
        $request->validate([

            'sub_tim_id' => 'required|exists:sub_tim,id',
            'nama_sop' => 'required|string|max:255',
            'tanggal_dibuat' => 'required|date',
            'tanggal_berlaku' => 'required|date',
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['sub_tim_id', 'nama_sop', 'tanggal_dibuat', 'tanggal_berlaku', 'keterangan']);

            if ($request->hasFile('file')) {
                if ($sopKeluar->file && Storage::disk('public')->exists($sopKeluar->file)) {
                    Storage::disk('public')->delete($sopKeluar->file);
                }
                $data['file'] = $request->file('file')->store('sopkeluar', 'public');
            }

            $sopKeluar->update($data);

            DB::commit();
            return redirect()->route('sop-keluar.index')->with('success', 'SOP Keluar berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }

    public function destroy(SopKeluar $sopKeluar)
    {
        try {
            if ($sopKeluar->file && Storage::disk('public')->exists($sopKeluar->file)) {
                Storage::disk('public')->delete($sopKeluar->file);
            }

            $sopKeluar->delete();

            return redirect()->route('sop-keluar.index')->with('success', 'SOP Keluar berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }

}
