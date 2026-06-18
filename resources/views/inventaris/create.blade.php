<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Inventaris') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-indigo-600">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('inventaris.store') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Kode Barang</label>
                                <input type="text" name="kode_barang" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 uppercase focus:outline-none focus:ring-indigo-500" required placeholder="Contoh: INV-HT-001">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                                <input type="text" name="nama_barang" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-indigo-500" required placeholder="Contoh: HT Motorola">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                                <select name="kategori" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-indigo-500" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Elektronik & Komunikasi">Elektronik & Komunikasi</option>
                                    <option value="Perlengkapan Keamanan">Perlengkapan Keamanan</option>
                                    <option value="Seragam & Atribut">Seragam & Atribut</option>
                                    <option value="Kendaraan">Kendaraan</option>
                                    <option value="Fasilitas Pos">Fasilitas Pos</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Unit</label>
                                <input type="number" name="jumlah" min="1" value="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Kondisi Saat Ini</label>
                                <select name="kondisi" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-indigo-500" required>
                                    <option value="Bagus">Bagus</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-4 bg-gray-50 rounded border">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tahun Perolehan / Pembelian</label>
                                <input type="number" name="tahun_perolehan" min="2000" max="{{ date('Y') }}" value="{{ date('Y') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-indigo-500" required>
                                <p class="text-xs text-gray-500 mt-1">*Digunakan untuk menghitung umur aset.</p>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Estimasi Harga Satuan (Rp)</label>
                                <input type="number" name="estimasi_harga" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-indigo-500" required placeholder="Contoh: 1500000">
                                <p class="text-xs text-gray-500 mt-1">*Tulis angka saja tanpa titik/koma.</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('inventaris.index') }}" class="text-gray-500 hover:text-gray-800 font-semibold mr-4">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all">
                                Simpan Data Barang
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>