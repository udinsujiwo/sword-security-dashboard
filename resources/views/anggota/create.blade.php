<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Anggota Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('anggota.store') }}">
                        @csrf
                        
                        <!-- Input Nama -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500" required placeholder="Masukkan nama lengkap petugas">
                        </div>

                        <!-- Input Email / NIK -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email / NIK</label>
                            <input type="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500" required placeholder="contoh: budi@swordsecurity.com">
                        </div>

                        <!-- Input Password -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Password Akun</label>
                            <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500" required>
                        </div>

                        <!-- Pilihan Jabatan -->
                        <div class="mb-8">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jabatan</label>
                            <select name="role" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500">
                                <option value="petugas">Petugas Keamanan</option>
                                <option value="danru">Komandan Regu (Danru)</option>
                            </select>
                        </div>

                        <!-- Tombol Batal & Simpan -->
                        <div class="flex items-center justify-end">
                            <a href="{{ route('anggota.index') }}" class="text-gray-500 hover:text-gray-800 font-semibold mr-4">Batal</a>
                            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all">
                                Simpan Anggota
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>