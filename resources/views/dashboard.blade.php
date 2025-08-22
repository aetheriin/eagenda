<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-black-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Statistik -->
            <div class="flex flex-wrap gap-6">
                <!-- Card Naskah Masuk -->
                <div class="bg-white shadow-lg rounded-lg p-4 text-black text-center flex-1 min-w-[200px]">
                    <div class="flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-sm font-bold">Jumlah Naskah Dinas Masuk</h3>
                        <p class="text-xl font-semibold text-blue-600">{{ $totalMasuk }}</p>
                        <a href="{{ route('naskah-masuk.index') }}" class="mt-2 inline-block text-sm text-blue-500 hover:text-blue-700">
                            Selengkapnya →
                        </a>
                    </div>
                </div>

                <!-- Card Naskah Keluar -->
                <div class="bg-white shadow-lg rounded-lg p-4 text-black text-center flex-1 min-w-[200px]">
                    <div class="flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <h3 class="text-sm font-bold">Jumlah Naskah Dinas Keluar</h3>
                        <p class="text-xl font-semibold text-red-600">{{ $totalKeluar }}</p>
                    </div>
                </div>

                <!-- Card User -->
                <div class="bg-white shadow-lg rounded-lg p-4 text-black text-center flex-1 min-w-[200px]">
                    <div class="flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                        </svg>
                        <h3 class="text-sm font-bold">Jumlah User</h3>
                        <p class="text-xl font-semibold text-green-600">{{ $totalUser }}</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Wrapper tabel berada di luar max-w-7xl supaya lebar mengikuti tabel -->
        <div class="flex justify-start py-6">
            <div class="overflow-x-auto inline-block">
                <div class="bg-white shadow-lg rounded-lg p-6 min-w-max">
                    <h3 class="text-lg font-bold mb-4 text-start">Naskah Dinas Keluar Menurut Jenisnya Tahun {{ $selectedYear }}</h3>

                    <table class="border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border min-w-[250px]">Jenis Naskah Dinas</th>
                                <th class="px-4 py-2 border min-w-[250px]">Jumlah</th>
                                <th class="px-4 py-2 border min-w-[250px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $routes = [
                                    'Memorandum Keluar' => 'memorandum-keluar.index',
                                    'Belanja Keluar' => 'belanja-keluar.index',
                                    'Surat Tugas' => 'surat-tugas.index',
                                    'Surat Dinas' => 'surat-dinas.index',
                                    'Undangan Internal' => 'undangan-internal.index',
                                    'Undangan Eksternal' => 'undangan-eksternal.index',
                                    'SOP Keluar' => 'sop-keluar.index',
                                ];
                            @endphp

                            @foreach($naskahKeluarByJenis as $index => $item)
                                <tr class="text-center">
                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border min-w-[250px]">{{ $item['jenis'] }}</td>
                                    <td class="px-4 py-2 border">{{ $item['jumlah'] }}</td>
                                    <td class="px-4 py-2 border">
                                        @if(isset($routes[$item['jenis']]))
                                            <a href="{{ route($routes[$item['jenis']]) }}" class="text-blue-500 hover:text-blue-700">
                                                Selengkapnya →
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
