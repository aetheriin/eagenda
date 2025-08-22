<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SOP Keluar') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('sop-keluar.update', $sopKeluar->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h2 class="text-l font-semibold text-gray-800 mb-6">
                        Edit SOP Keluar
                    </h2>

                    <!-- Nomor Naskah -->
                    <!-- <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nomor Naskah</label>
                        <input type="text" name="nomor_naskah" class="w-full border rounded px-3 py-2" value="{{ old('nomor_naskah', $sopKeluar->nomor_naskah) }}">
                    </div> -->

                    <!-- Tim / Subtim -->
                     <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Tim / Subtim</label>
                        <input type="text" name="subtim" class="w-full border rounded px-3 py-2" value="{{ old('subtim', $sopKeluar->subtim) }}">
                    </div>

                    <!-- Nama SOP -->
                     <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nama SOP</label>
                        <input type="text" name="nama_sop" class="w-full border rounded px-3 py-2" value="{{ old('nama_sop', $sopKeluar->nama_sop) }}">
                    </div>

                    <!-- Perihal -->
                    <!-- <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Perihal</label>
                        <input type="text" name="perihal" class="w-full border rounded px-3 py-2" value="{{ old('perihal', $sopKeluar->perihal) }}">
                    </div> -->

                    <!-- Tujuan/Penerima -->
                    <!-- <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Tujuan/Penerima</label>
                        <input type="text" name="tujuan_penerima" class="w-full border rounded px-3 py-2" value="{{ old('tujuan_penerima', $sopKeluar->tujuan_penerima) }}">
                    </div> -->

                    <!-- Tanggal dibuat -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Tanggal Dibuat</label>
                        <input type="date" name="tanggal_dibuat" class="w-full border rounded px-3 py-2" value="{{ old('tanggal_dibuat', $sopKeluar->tanggal_dibuat) }}">
                    </div>

                    <!-- Tanggal berlaku -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Tanggal Berlaku</label>
                        <input type="date" name="tanggal_berlaku" class="w-full border rounded px-3 py-2" value="{{ old('tanggal_berlaku', $sopKeluar->tanggal_berlaku) }}">
                    </div>

                    <!-- File Upload -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Upload File (Kosongkan jika tidak diganti)</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx" required class="w-full border rounded px-3 py-2">
                        <p class="text-sm text-gray-500 mt-1">File saat ini: 
                            <a href="{{ asset('storage/' . $sopKeluar->file) }}" target="_blank" class="text-blue-600">Lihat File</a>
                        </p>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Keterangan</label>
                        <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2">{{ old('keterangan', $sopKeluar->keterangan) }}</textarea>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('sop-keluar.index') }}" 
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-3"
                            style="background-color:#2563eb; color:white;">
                            Update
                        </button>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
