<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Laporan Patroli</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('laporan.update', $laporan->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Nama Petugas</label>
                        <select name="user_id" class="w-full border rounded p-2" required>
                            @foreach ($petugas as $p)
                                <option value="{{ $p->id }}" {{ $laporan->user_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ $laporan->tanggal }}" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Waktu</label>
                            <input type="time" name="waktu_laporan" value="{{ $laporan->waktu_laporan }}" class="w-full border rounded p-2" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Uraian Kegiatan</label>
                        <textarea name="uraian_kegiatan" rows="4" class="w-full border rounded p-2" required>{{ $laporan->uraian_kegiatan }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Kondisi</label>
                        <select name="kondisi" class="w-full border rounded p-2">
                            <option value="Aman" {{ $laporan->kondisi == 'Aman' ? 'selected' : '' }}>Aman</option>
                            <option value="Terdapat Kendala" {{ $laporan->kondisi == 'Terdapat Kendala' ? 'selected' : '' }}>Terdapat Kendala</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold mb-2">Foto Bukti (Kosongkan jika tidak diubah)</label>
                        @if($laporan->foto_bukti)
                            <p class="text-xs text-gray-500 mb-2">Foto saat ini: {{ $laporan->foto_bukti }}</p>
                        @endif
                        <input type="file" name="foto_bukti" class="w-full">
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('laporan.index') }}" class="mr-4 pt-2 text-gray-500">Batal</a>
                        <button type="submit" class="bg-yellow-500 text-white font-bold py-2 px-6 rounded">Update Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>