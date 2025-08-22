<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Naskah Dinas Masuk') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 w-1/3">
                <form id="laporanForm">
                    <div class="space-y-4">
                        <!-- Pilih Tanggal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                            <input type="date" name="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <!-- Tombol Export -->
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Cetak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('laporanForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let start = document.querySelector('input[name="start_date"]').value;
            let end   = document.querySelector('input[name="end_date"]').value;

            if(start && end) {
                window.location.href = `/laporan/naskah-masuk/export?start_date=${start}&end_date=${end}`;
            } else {
                alert("Silakan lengkapi tanggal mulai dan akhir sebelum export!");
            }
        });
    </script>
</x-app-layout>
