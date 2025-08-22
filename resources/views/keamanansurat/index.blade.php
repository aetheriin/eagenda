<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Akses/Keamanan Surat') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- ✅ Card Kontainer -->
            <div class="bg-white shadow rounded-lg p-6">
                
                <!-- ✅ Header Tabel dan Tombol -->
                <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Daftar Akses/Keamanan Surat</h3>

                <div class="flex items-center gap-4">
                    <!-- Dropdown Filter -->
                    <select name="per_page"
                        class="appearance-none border border-gray-300 rounded-lg px-3 py-2 text-sm h-10 min-w-[100px] 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                        onchange="this.form.submit()">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>

                    <!-- Input Search + Tombol Cari -->
                    <form method="GET" action="{{ route('keamanan-surat.index') }}" class="flex items-center space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="kode atau nama"
                            class="border border-gray-300 rounded px-3 py-2 text-sm w-48 h-10">
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm h-10">
                            Cari
                        </button>
                    </form>
                </div>
            </div>
                <!-- ✅ Tabel -->
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300 text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border text-center w-6">No</th>
                                <th class="px-4 py-2 border w-6">Kode</th>
                                <th class="px-4 py-2 border w-auto">Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keamananSurat as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border text-center">
                                        {{ $loop->iteration + ($keamananSurat->currentPage() - 1) * $keamananSurat->perPage() }}
                                    </td>
                                    <td class="px-4 py-2 border">{{ $item->kode }}</td>
                                    <td class="px-4 py-2 border">{{ $item->nama }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- ✅ Pagination -->
                <div class="mt-4">
                    {{ $keamananSurat->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
