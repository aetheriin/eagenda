<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Memorandum Keluar') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Card Form -->
            <div class="bg-white shadow rounded-lg p-6">

                <!-- Judul di Dalam Card -->
                <h2 class="text-l font-semibold text-gray-800 mb-6">
                    Tambah Memorandum Keluar
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

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <!-- Form -->
                <form action="{{ route('memorandum-keluar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nomor Urut -->
                    <x-input-nomor-urut :value="$nomorUrut" />


                    <!-- Bagian/Fungsi + Klasifikasi -->
                    <div class="flex gap-4 mb-4">
                        <!-- Bagian Fungsi -->
                        <div class="w-3/4">
                            <label class="block text-gray-700 font-semibold mb-1" for="bagian_fungsi_id">Bagian / Fungsi</label>
                            <select name="bagian_fungsi_id" id="bagian_fungsi_id"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">-- Pilih Bagian / Fungsi --</option>
                                @foreach($bagianFungsi as $bagian)
                                    <option value="{{ $bagian->id }}" {{ old('bagian_fungsi_id') == $bagian->id ? 'selected' : '' }}>
                                        {{ $bagian->nama_bagian }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Klasifikasi -->
                        <div class="w-1/3">
                            <label class="block text-gray-700 font-semibold mb-1">Klasifikasi <span class="text-red-500">*</span></label>
                            <input type="text" name="klasifikasi_naskah_id" value="{{ old('klasifikasi_naskah_id') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required />
                        </div>
                    </div>



                    <!-- Perihal -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Perihal <span class="text-red-500">*</span></label>
                        <input type="text" name="perihal" value="{{ old('perihal') }}" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- Tujuan/Penerima -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Tujuan/Penerima <span class="text-red-500">*</span></label>
                        <input type="text" name="tujuan_penerima" value="{{ old('tujuan_penerima') }}" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- File Upload -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Upload File (PDF/DOC)</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx" 
                               class="w-full text-gray-700" />
                        <p class="text-sm text-gray-500">Hanya file PDF atau Word (Max 2MB)</p>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Keterangan</label>
                        <textarea name="keterangan" rows="3" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end gap-4 mt-4">
                        <a href="{{ route('memorandum-keluar.index') }}" 
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" 
                            class="font-bold py-2 px-4 rounded text-white"
                            style="background-color:#2563eb;"> 
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
