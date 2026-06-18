<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Laporan Insiden') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-yellow-500">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('kejadian.update', $kejadian->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pelapor</label>
                                <select name="user_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                                    @foreach ($petugas as $p)
                                        <option value="{{ $p->id }}" {{ $kejadian->user_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kejadian</label>
                                <select name="jenis_kejadian" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                                    <option value="Pencurian / Kehilangan" {{ $kejadian->jenis_kejadian == 'Pencurian / Kehilangan' ? 'selected' : '' }}>Pencurian / Kehilangan</option>
                                    <option value="Kerusakan Fasilitas" {{ $kejadian->jenis_kejadian == 'Kerusakan Fasilitas' ? 'selected' : '' }}>Kerusakan Fasilitas</option>
                                    <option value="Tamu VIP / Kunjungan" {{ $kejadian->jenis_kejadian == 'Tamu VIP / Kunjungan' ? 'selected' : '' }}>Tamu VIP / Kunjungan</option>
                                    <option value="Kecelakaan Kerja" {{ $kejadian->jenis_kejadian == 'Kecelakaan Kerja' ? 'selected' : '' }}>Kecelakaan Kerja</option>
                                    <option value="Keributan / Tindak Kekerasan" {{ $kejadian->jenis_kejadian == 'Keributan / Tindak Kekerasan' ? 'selected' : '' }}>Keributan / Tindak Kekerasan</option>
                                    <option value="Lainnya" {{ $kejadian->jenis_kejadian == 'Lainnya' ? 'selected' : '' }}>Lainnya...</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kejadian</label>
                                <input type="date" name="tanggal_kejadian" value="{{ $kejadian->tanggal_kejadian }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Perkiraan Waktu Kejadian</label>
                                <input type="time" name="waktu_kejadian" value="{{ \Carbon\Carbon::parse($kejadian->waktu_kejadian)->format('H:i') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kronologi Lengkap</label>
                            <textarea name="kronologi" rows="4" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>{{ $kejadian->kronologi }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tindakan Penyelesaian</label>
                            <textarea name="tindakan_diambil" rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>{{ $kejadian->tindakan_diambil }}</textarea>
                        </div>

                        <div class="mb-8 p-4 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Foto Bukti (Biarkan kosong jika tidak ingin mengganti foto)</label>
                            @if($kejadian->foto_kejadian)
                                <div class="mb-3">
                                    <span class="text-xs text-gray-600 bg-yellow-100 py-1 px-2 rounded">Foto saat ini tersimpan.</span>
                                </div>
                            @endif
                            <input type="file" name="foto_kejadian" accept="image/*" class="w-full text-gray-700">
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('kejadian.index') }}" class="text-gray-500 hover:text-gray-800 font-semibold mr-4">Batal</a>
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all">
                                Update Data Insiden
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>