<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Laporan Insiden / Kejadian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-red-600">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('kejadian.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pelapor (Petugas)</label>
                                <select name="user_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-red-500" required>
                                    <option value="">-- Pilih Petugas Jaga --</option>
                                    @foreach ($petugas as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }} ({{ strtoupper($p->role) }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kejadian</label>
                                <select name="jenis_kejadian" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-red-500" required>
                                    <option value="">-- Pilih Jenis Insiden --</option>
                                    <option value="Pencurian / Kehilangan">Pencurian / Kehilangan</option>
                                    <option value="Kerusakan Fasilitas">Kerusakan Fasilitas</option>
                                    <option value="Tamu VIP / Kunjungan">Tamu VIP / Kunjungan</option>
                                    <option value="Kecelakaan Kerja">Kecelakaan Kerja</option>
                                    <option value="Keributan / Tindak Kekerasan">Keributan / Tindak Kekerasan</option>
                                    <option value="Lainnya">Lainnya...</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kejadian</label>
                                <input type="date" name="tanggal_kejadian" value="{{ date('Y-m-d') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-red-500" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Perkiraan Waktu Kejadian</label>
                                <input type="time" name="waktu_kejadian" value="{{ date('H:i') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-red-500" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kronologi Lengkap</label>
                            <textarea name="kronologi" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-red-500" required placeholder="Ceritakan secara detail bagaimana insiden ini terjadi..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tindakan Penyelesaian / Penanganan Pertama</label>
                            <textarea name="tindakan_diambil" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-red-500" required placeholder="Contoh: Mengamankan area, melapor ke polisi, membawa korban ke klinik..."></textarea>
                        </div>

                        <div class="mb-8 p-4 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Unggah Foto Dokumentasi Kejadian (Opsional tapi disarankan)</label>
                            <input type="file" name="foto_kejadian" accept="image/*" class="w-full text-gray-700">
                            <p class="text-xs text-gray-500 mt-1">*Format: JPG/PNG, Maksimal ukuran file 2MB.</p>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('kejadian.index') }}" class="text-gray-500 hover:text-gray-800 font-semibold mr-4">Batal</a>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all">
                                Simpan Data Insiden
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>