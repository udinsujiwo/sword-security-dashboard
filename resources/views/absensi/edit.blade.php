<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Absensi Petugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('absensi.update', $absensi->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Petugas</label>
                            <select name="user_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-green-500" required>
                                @foreach ($petugas as $p)
                                    <option value="{{ $p->id }}" {{ $absensi->user_id == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ strtoupper($p->role) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ $absensi->tanggal }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-green-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jam Masuk</label>
                                <input type="time" name="waktu_masuk" value="{{ \Carbon\Carbon::parse($absensi->waktu_masuk)->format('H:i') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-green-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Shift Jaga</label>
                                <select name="shift" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-green-500" required>
                                    <option value="pagi" {{ $absensi->shift == 'pagi' ? 'selected' : '' }}>Pagi (07:00 - 19:00)</option>
                                    <option value="malam" {{ $absensi->shift == 'malam' ? 'selected' : '' }}>Malam (19:00 - 07:00)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Status Kehadiran</label>
                                <select name="status_kehadiran" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-green-500" required>
                                    <option value="Hadir" {{ $absensi->status_kehadiran == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Sakit" {{ $absensi->status_kehadiran == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                    <option value="Izin" {{ $absensi->status_kehadiran == 'Izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="Alpa" {{ $absensi->status_kehadiran == 'Alpa' ? 'selected' : '' }}>Alpa (Tanpa Keterangan)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan (Opsional)</label>
                            <textarea name="keterangan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-green-500">{{ $absensi->keterangan }}</textarea>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('absensi.index') }}" class="text-gray-500 hover:text-gray-800 font-semibold mr-4">Batal</a>
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all">
                                Update Absensi
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>