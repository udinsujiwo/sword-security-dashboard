<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Laporan Patroli') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Petugas</label>
                            <select name="user_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500" required>
                                <option value="">-- Pilih Petugas Jaga --</option>
                                @foreach ($petugas as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ strtoupper($p->role) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jam Laporan</label>
                                <input type="time" name="waktu_laporan" value="{{ date('H:i') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Kondisi Area</label>
                                <select name="kondisi" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                                    <option value="Aman">Aman & Terkendali</option>
                                    <option value="Terdapat Kendala">Terdapat Kendala</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Uraian Kegiatan / Patroli</label>
                            <textarea name="uraian_kegiatan" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required placeholder="Contoh: Melakukan pengecekan area gudang belakang, lampu menyala, situasi kondusif..."></textarea>
                        </div>

                        <div class="mb-8">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Unggah Foto Bukti (Opsional)</label>
                            <input type="file" name="foto_bukti" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('laporan.index') }}" class="text-gray-500 hover:text-gray-800 font-semibold mr-4">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all">
                                Simpan Laporan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>