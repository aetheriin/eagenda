<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Undangan Internal Keluar') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-white shadow rounded-lg p-6">

                <h2 class="text-l font-semibold text-gray-800 mb-6">
                    Edit Undangan Internal Keluar
                </h2>

                <!-- Pesan Error -->
                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('undangan-internal.update', $undanganInternal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nomor Naskah -->
                    <x-input-nomor-naskah :value="$undanganInternal->nomor_naskah" readonly="true" />

                    <!-- Keamanan Surat -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1" for="keamanan_surat_id">
                            Keamanan Surat <span class="text-red-500">*</span>
                        </label>
                        <select name="keamanan_surat_id" id="keamanan_surat_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">-- Pilih Keamanan Surat --</option>
                            @foreach($keamananSurat as $keamanan)
                                <option value="{{ $keamanan->id }}"
                                    {{ old('keamanan_surat_id', $undanganInternal->keamanan_surat_id) == $keamanan->id ? 'selected' : '' }}>
                                    {{ $keamanan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bagian/Fungsi + Klasifikasi -->
                    <div class="flex gap-4 mb-4">
                        <!-- Bagian Fungsi -->
                        <div class="w-3/4">
                            <label class="block text-gray-700 font-semibold mb-1" for="bagian_fungsi_id">
                                Bagian / Fungsi <span class="text-red-500">*</span>
                            </label>
                            <select name="bagian_fungsi_id" id="bagian_fungsi_id"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">-- Pilih Bagian / Fungsi --</option>
                                @foreach($bagianFungsi as $bagian)
                                    <option value="{{ $bagian->id }}"
                                        {{ old('bagian_fungsi_id', $undanganInternal->bagian_fungsi_id) == $bagian->id ? 'selected' : '' }}>
                                        {{ $bagian->nama_bagian }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Klasifikasi -->
                        <div class="w-1/3">
                            <label class="block text-gray-700 font-semibold mb-1">
                                Klasifikasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="klasifikasi_naskah_id"
                                value="{{ old('klasifikasi_naskah_id', $undanganInternal->klasifikasiNaskah->nama_klasifikasi ?? '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required />
                        </div>
                    </div>

                    <!-- Perihal -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Perihal <span class="text-red-500">*</span></label>
                        <input type="text" name="perihal" value="{{ old('perihal', $undanganInternal->perihal) }}" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- Tujuan/Penerima -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Tujuan/Penerima <span class="text-red-500">*</span></label>
                        <input type="text" name="tujuan_penerima" value="{{ old('tujuan_penerima', $undanganInternal->tujuan_penerima) }}" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $undanganInternal->tanggal) }}" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- File Upload -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Upload File (PDF/DOC)</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx"
                               class="w-full text-gray-700" />
                        @if($undanganInternal->file)
                            <p class="text-sm text-gray-500 mt-1">
                                File saat ini:
                                <a href="{{ asset('storage/' . $undanganInternal->file) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                            </p>
                        @endif
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Keterangan</label>
                        <textarea name="keterangan" rows="3"
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan', $undanganInternal->keterangan) }}</textarea>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end gap-4 mt-4">
                        <a href="{{ route('undangan-internal.index') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" 
                            class="font-bold py-2 px-4 rounded text-white"
                            style="background-color:#2563eb;">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
