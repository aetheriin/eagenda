<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Naskah Dinas Keluar') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 w-1/3">
                <form action="" method="GET" id="laporanForm">
                    @csrf

                    <div class="space-y-4">
                        <!-- Pilih Jenis Laporan -->
                        <div>
                            <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis Laporan</label>
                            <select name="jenis" id="jenis" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="memorandum-keluar">Memorandum Keluar</option>
                                <option value="belanja-keluar">Belanja Keluar</option>
                                <option value="surat-tugas">Surat Tugas</option>
                                <option value="surat-dinas">Surat Dinas</option>
                                <option value="undangan-internal">Undangan Internal</option>
                                <option value="undangan-eksternal">Undangan Eksternal</option>
                                <option value="sop-keluar">SOP Keluar</option>
                            </select>
                        </div>

                        <!-- Pilih Tanggal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                            <input type="date" name="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <!-- Tombol Export -->
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-red-700">
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

            let jenis = document.getElementById('jenis').value;
            let start = document.querySelector('input[name="start_date"]').value;
            let end   = document.querySelector('input[name="end_date"]').value;

            if(jenis && start && end) {
                window.location.href = `/laporan/${jenis}/export?start_date=${start}&end_date=${end}`;
            } else {
                alert("Silakan lengkapi semua field sebelum export!");
            }
        });
    </script>
</x-app-layout>
