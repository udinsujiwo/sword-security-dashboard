<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Inventaris') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-yellow-500">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('inventaris.update', $inventaris->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Kode Barang</label>
                                <input type="text" name="kode_barang" value="{{ $inventaris->kode_barang }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 uppercase focus:outline-none" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                                <input type="text" name="nama_barang" value="{{ $inventaris->nama_barang }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                                <select name="kategori" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none" required>
                                    <option value="Elektronik & Komunikasi" {{ $inventaris->kategori == 'Elektronik & Komunikasi' ? 'selected' : '' }}>Elektronik & Komunikasi</option>
                                    <option value="Perlengkapan Keamanan" {{ $inventaris->kategori == 'Perlengkapan Keamanan' ? 'selected' : '' }}>Perlengkapan Keamanan</option>
                                    <option value="Seragam & Atribut" {{ $inventaris->kategori == 'Seragam & Atribut' ? 'selected' : '' }}>Seragam & Atribut</option>
                                    <option value="Kendaraan" {{ $inventaris->kategori == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                                    <option value="Fasilitas Pos" {{ $inventaris->kategori == 'Fasilitas Pos' ? 'selected' : '' }}>Fasilitas Pos</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Unit</label>
                                <input type="number" name="jumlah" value="{{ $inventaris->jumlah }}" min="1" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Kondisi Saat Ini</label>
                                <select name="kondisi" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none" required>
                                    <option value="Bagus" {{ $inventaris->kondisi == 'Bagus' ? 'selected' : '' }}>Bagus</option>
                                    <option value="Rusak Ringan" {{ $inventaris->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ $inventaris->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-4 bg-gray-50 rounded border">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tahun Perolehan</label>
                                <input type="number" name="tahun_perolehan" value="{{ $inventaris->tahun_perolehan }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Estimasi Harga Satuan (Rp)</label>
                                <input type="number" name="estimasi_harga" value="{{ (int)$inventaris->estimasi_harga }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('inventaris.index') }}" class="text-gray-500 hover:text-gray-800 font-semibold mr-4">Batal</a>
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all">
                                Update Data Barang
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>