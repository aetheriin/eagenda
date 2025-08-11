<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-black-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $selectedYear = session('tahun_selected', now()->year);
        $total = 0;
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold">Memorandum Keluar</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah untuk tahun {{ $selectedYear }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-semibold">{{ $total }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
