<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-black-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Kelola Akun -->
                <a href="{{ route('users.index') }}" 
                   class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg hover:shadow-lg transition">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Kelola Akun</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Tambah, edit, atau hapus akun pengguna</p>
                </a>

                <!-- Klasifikasi Naskah -->
                <a href="{{ route('klasifikasi-naskah.create') }}" 
                   class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg hover:shadow-lg transition">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Klasifikasi Naskah</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Kelola jenis klasifikasi naskah</p>
                </a>

                <!-- Keamanan Surat -->
                <a href="{{ route('keamanan-surat.create') }}" 
                   class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg hover:shadow-lg transition">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Keamanan Surat</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Kelola level keamanan surat</p>
                </a>

                <!-- Bagian Fungsi -->
                <a href="{{ route('bagian-fungsi.create') }}" 
                   class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg hover:shadow-lg transition">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Bagian Fungsi</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Atur bagian fungsi organisasi</p>
                </a>

                <!-- Subtim -->
                <a href="{{ route('sub-tim.create') }}" 
                   class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg hover:shadow-lg transition">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Subtim</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Kelola subtim dalam organisasi</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
