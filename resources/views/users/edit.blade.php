<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h2 class="text-l font-semibold text-gray-800 mb-6">
                        Edit User
                    </h2>

                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full border rounded px-3 py-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full border rounded px-3 py-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password"
                               class="w-full border rounded px-3 py-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               class="w-full border rounded px-3 py-2" />
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('users.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
