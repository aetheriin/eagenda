<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bagian/Fungsi') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-6">
            <!-- ✅ Card Form -->
            <div class="bg-white shadow rounded-lg p-6">

                <!-- ✅ Judul di Dalam Card -->
                <h2 class="text-l font-semibold text-gray-800 mb-6">
                    Tambah Bagian/Fungsi
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

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif


                <!-- ✅ Form -->
                <form action="{{ route('bagian-fungsi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nomor Urut -->
                    <x-input-nomor-urut :value="$nomorUrut" />

                    <!-- Kode -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Kode BPS<span class="text-red-500">*</span></label>
                        <input type="text" name="kode_bps" value="{{ old('kode_bps') }}" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Nama Bagian/Fungsi <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_bagian" value="{{ old('nama_bagian') }}" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end gap-4 mt-4">
                        <a href="{{ route('profile.admin') }}" 
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
