<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Naskah Dinas Masuk') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('naskah-masuk.update', $naskahMasuk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h2 class="text-l font-semibold text-gray-800 mb-6">
                        Edit Naskah Dinas Masuk
                    </h2>

                    <!-- Nomor Naskah -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nomor Naskah</label>
                        <input type="text" name="nomor_naskah" class="w-full border rounded px-3 py-2" value="{{ old('nomor_naskah', $naskahMasuk->nomor_naskah) }}">
                    </div>

                    <!-- Perihal -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Perihal</label>
                        <input type="text" name="perihal" class="w-full border rounded px-3 py-2" value="{{ old('perihal', $naskahMasuk->perihal) }}">
                    </div>

                    <!-- Asal Pengirim -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Asal/Pengirim</label>
                        <input type="text" name="asal_pengirim" class="w-full border rounded px-3 py-2" value="{{ old('asal_pengirim', $naskahMasuk->asal_pengirim) }}">
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Tanggal</label>
                        <input type="date" name="tanggal" class="w-full border rounded px-3 py-2" value="{{ old('tanggal', $naskahMasuk->tanggal) }}">
                    </div>

                    <!-- File Upload -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Upload File (Kosongkan jika tidak diganti)</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx" required class="w-full border rounded px-3 py-2">
                        <p class="text-sm text-gray-500 mt-1">File saat ini: 
                            <a href="{{ asset('storage/' . $naskahMasuk->file) }}" target="_blank" class="text-blue-600">Lihat File</a>
                        </p>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Keterangan</label>
                        <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2">{{ old('keterangan', $naskahMasuk->keterangan) }}</textarea>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('naskah-masuk.index') }}" 
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
