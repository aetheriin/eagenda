<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Naskah Dinas Masuk') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-6">
            <!-- ✅ Card Form -->
            <div class="bg-white shadow rounded-lg p-6">

                <!-- ✅ Judul di Dalam Card -->
                <h2 class="text-l font-semibold text-gray-800 mb-6">
                    Tambah Naskah Dinas Masuk
                </h2>

                <!-- ✅ Pesan Error -->
                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- ✅ Form -->
                <form action="{{ route('naskah-masuk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nomor Urut -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Nomor Urut <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_urut" value="{{ $nomorUrut }}" readonly
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- Nomor Naskah -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Nomor Naskah <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_naskah" value="{{ old('nomor_naskah') }}" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- Perihal -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Perihal <span class="text-red-500">*</span></label>
                        <input type="text" name="perihal" value="{{ old('perihal') }}" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- Asal Pengirim -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Asal/Pengirim <span class="text-red-500">*</span></label>
                        <input type="text" name="asal_pengirim" value="{{ old('asal_pengirim') }}" required
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
                        <label class="block text-gray-700 font-semibold mb-1">Upload File (PDF/DOC) <span class="text-red-500">*</span></label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx" required
                               class="w-full text-gray-700" />
                        <p class="text-sm text-gray-500">Hanya file PDF atau Word (Max 2MB)</p>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Keterangan <span class="text-red-500">*</span></label>
                        <textarea name="keterangan" rows="3" required
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- Tombol -->
                    <!-- Tombol -->
                    <div class="flex justify-end gap-4 mt-4">
                        <a href="{{ route('naskah-masuk.index') }}" 
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" 
                            class="font-bold py-2 px-4 rounded text-white"
                            style="background-color:#2563eb;"> <!-- Tailwind bg-blue-600 -->
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
