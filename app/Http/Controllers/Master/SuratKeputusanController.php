<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SuratKeputusan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratKeputusanController extends Controller
{
    public function index(Request $request)
    {
        // Pencarian
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nomor_naskah', 'like', "%{$search}%")
                ->orWhere('perihal', 'like', "%{$search}%");
        }

        $perPage = $request->input('per_page', 10);
        $suratKeputusan = $query->orderBy('id', 'desc')->paginate($perPage);

        return view('suratkeputusan.index', compact('suratKeputusan'));
    }

    public function create()
    {
        $last = SuratKeputusan::latest('id')->first();
        $nomorUrut = $last ? $last->id + 1 : 1;

        return view('suratkeputusan.create', compact('nomorUrut'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nomor_urut'       => 'required',
                'perihal'          => 'required|string',
                'tujuan_penerima'  => 'required|string',
                'tanggal'          => 'required|date',
                'file'             => 'nullable|mimes:pdf,doc,docx|max:2048',
                'keterangan'       => 'nullable|string',
            ]);

            $nomorUrut = str_pad($validated['nomor_urut'], 2, '0', STR_PAD_LEFT);
            
            $nomorNaskah = 'B-'.$nomorUrut
                . '/' . now()->day
                . '/' . now()->month
                . '/' . $klasifikasi->kode_klasifikasi
                . '/' . now()->year;

            $path = $request->file('file')->store('belanja', 'public');

            SuratKeputusan::create([
                'nomor_naskah'          => $nomorNaskah,
                'perihal'               => $validated['perihal'],
                'tujuan_penerima'       => $validated['tujuan_penerima'],
                'tanggal'               => $validated['tanggal'],
                'file'                  => $path,
                'keterangan'            => $validated['keterangan'],
            ]);

            return redirect()->route('surat-keputusan.index')->with('success', 'Surat Keputusan berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $suratKeputusan = SuratKeputusan::findOrFail($id);

        return view('suratkeputusan.edit', compact('suratKeputusan'));
    }

    public function update(Request $request, SuratKeputusan $suratKeputusan)
    {
        $request->validate([
            'perihal' => 'required|string|max:255',
            'tujuan_penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $oldNomorUrut = strtok($suratKeputusan->nomor_naskah, '/');

            $nomorNaskah  = $oldNomorUrut
                . '/' . $bagianFungsi->kode_bps
                . '/' . $klasifikasi->kode_klasifikasi
                . '/' . now()->year;

            $data = [
                'perihal'               => $request->perihal,
                'tujuan_penerima'       => $request->tujuan_penerima,
                'tanggal'               => $request->tanggal,
                'keterangan'            => $request->keterangan,
                'nomor_naskah'          => $nomorNaskah,
            ];

            if ($request->hasFile('file')) {
                if ($suratKeputusan->file && Storage::disk('public')->exists($suratKeputusan->file)) {
                    Storage::disk('public')->delete($suratKeputusan->file);
                }
                $data['file'] = $request->file('file')->store('surat', 'public');
            }

            $suratKeputusan->update($data);

            DB::commit();
            return redirect()->route('surat-keputusan.index')->with('success', 'Surat Keputusan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }

    public function destroy(SuratKeputusan $suratKeputusan)
    {
        try {
            if ($suratKeputusan->file && Storage::disk('public')->exists($suratKeputusan->file)) {
                Storage::disk('public')->delete($suratKeputusan->file);
            }

            $suratKeputusan->delete();

            return redirect()->route('surat-keputusan.index')->with('success', 'Surat Keputusan berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
