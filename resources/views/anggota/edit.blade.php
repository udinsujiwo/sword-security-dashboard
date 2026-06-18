<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('anggota.update', $anggota->id) }}">
                        @csrf
                        @method('PUT') <!-- Ini wajib untuk proses Update data di Laravel -->
                        
                        <!-- Input Nama -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $anggota->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500" required>
                        </div>

                        <!-- Input Email / NIK -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email / NIK</label>
                            <input type="email" name="email" value="{{ old('email', $anggota->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500" required>
                        </div>

                        <!-- Input Password (Opsional) -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Password Baru (Kosongkan jika tidak ingin ganti)</label>
                            <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500">
                        </div>

                        <!-- Pilihan Jabatan -->
                        <div class="mb-8">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jabatan</label>
                            <select name="role" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500">
                                <option value="petugas" {{ $anggota->role == 'petugas' ? 'selected' : '' }}>Petugas Keamanan</option>
                                <option value="danru" {{ $anggota->role == 'danru' ? 'selected' : '' }}>Komandan Regu (Danru)</option>
                            </select>
                        </div>

                        <!-- Tombol Batal & Simpan -->
                        <div class="flex items-center justify-end">
                            <a href="{{ route('anggota.index') }}" class="text-gray-500 hover:text-gray-800 font-semibold mr-4">Batal</a>
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all">
                                Update Anggota
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>