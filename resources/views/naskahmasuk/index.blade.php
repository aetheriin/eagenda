<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Naskah Dinas Masuk') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Card Kontainer -->
            <div class="bg-white shadow rounded-lg p-6">
                
                <!-- Header Tabel dan Tombol -->
                <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Daftar Naskah Dinas Masuk</h3>

                <div class="flex items-center gap-4">
                    <!-- Dropdown Filter -->
                    <form method="GET" action="{{ route('naskah-masuk.index') }}">
                        <select name="per_page"
                            class="appearance-none border border-gray-300 rounded-lg px-3 py-2 text-sm h-10 min-w-[100px] 
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                            onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </form>

                    <!-- Input Search + Tombol Cari -->
                    <form method="GET" action="{{ route('naskah-masuk.index') }}" class="flex items-center space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari Nomor Naskah / Perihal"
                            class="border border-gray-300 rounded px-3 py-2 text-sm w-48 h-10">
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm h-10">
                            Cari
                        </button>
                    </form>

                    <!-- Tombol Tambah Naskah -->
                    <a href="{{ route('naskah-masuk.create') }}" 
                        class="inline-flex items-center text-white px-3 py-2 rounded text-sm font-semibold h-10"
                        style="background-color: #2680e7ff !important; transition: background-color 0.3s;"
                        onmouseover="this.style.backgroundColor='#bec2c5ff'" 
                        onmouseout="this.style.backgroundColor='#2680e7ff'">
                        + Tambah Naskah
                    </a>
                </div>
            </div>
                <!-- Tabel -->
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300 text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border text-center">No</th>
                                <th class="px-4 py-2 border">Nomor Naskah</th>
                                <th class="px-4 py-2 border">Perihal</th>
                                <th class="px-4 py-2 border">Asal/Pengirim</th>
                                <th class="px-4 py-2 border text-center">Tanggal</th>
                                <th class="px-4 py-2 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($naskahMasuk as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border text-center">
                                        {{ $loop->iteration + ($naskahMasuk->currentPage() - 1) * $naskahMasuk->perPage() }}
                                    </td>
                                    <td class="px-4 py-2 border">{{ $item->nomor_naskah }}</td>
                                    <td class="px-4 py-2 border">{{ $item->perihal }}</td>
                                    <td class="px-4 py-2 border">{{ $item->asal_pengirim }}</td>
                                    <td class="px-4 py-2 border text-center">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-2 border text-center">
                                        <div class="flex justify-center items-center gap-3">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('naskah-masuk.edit', $item->id) }}" 
                                            class="inline-flex items-center text-white px-3 py-2 rounded text-sm font-semibold"
                                            style="background-color: #16a34a !important; transition: background-color 0.3s;"
                                            onmouseover="this.style.backgroundColor='#15803d'" 
                                            onmouseout="this.style.backgroundColor='#16a34a'">
                                                <!-- Ikon Pensil -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L7.5 21H3v-4.5L16.732 3.732z" />
                                                </svg>
                                                Edit
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('naskah-masuk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="inline-flex items-center text-white px-3 py-2 rounded text-sm font-semibold"
                                                    style="background-color: #dc2626 !important; transition: background-color 0.3s;"
                                                    onmouseover="this.style.backgroundColor='#b91c1c'" 
                                                    onmouseout="this.style.backgroundColor='#dc2626'">
                                                    <!-- Ikon Tong Sampah -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $naskahMasuk->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
