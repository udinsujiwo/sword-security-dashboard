<x-app-layout>
    <!-- Bagian Judul Halaman (Header) -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Anggota Sword Security') }}
        </h2>
    </x-slot>

    <!-- Bagian Isi Konten -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            
            <!-- Alert Notifikasi Sukses -->
         @if (session('success'))
             <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                 <span class="block sm:inline font-bold">{{ session('success') }}</span>
             </div>
         @endif

            <!-- Tombol Tambah Anggota -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-700">Daftar Petugas & Danru</h3>
                <a href="{{ route('anggota.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all">
                    + Tambah Anggota Baru
                </a>
            </div>
            
            <!-- Tabel Data Anggota -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-slate-800 text-white">
                            <th class="py-3 px-4 border-b text-left font-semibold">Nama Lengkap</th>
                            <th class="py-3 px-4 border-b text-left font-semibold">Email / NIK</th>
                            <th class="py-3 px-4 border-b text-left font-semibold">Jabatan</th>
                            <th class="py-3 px-4 border-b text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($anggota as $item)
                            <!-- Baris ini akan berulang sebanyak data anggota yang ada -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-4 border-b text-gray-800 font-medium">{{ $item->name }}</td>
                                <td class="py-3 px-4 border-b text-gray-600">{{ $item->email }}</td>
                                <td class="py-3 px-4 border-b text-gray-600 uppercase text-xs font-bold tracking-wider">{{ $item->role }}</td>
                                <td class="py-3 px-4 border-b text-center">
                                    <!-- Tombol Edit & Hapus (Kita fungsikan nanti) -->
                                    
                                    <a href="{{ route('anggota.edit', $item->id) }}" class="inline-block text-sm bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded mr-1 transition">Edit</a>
                                    <form action="{{ route('anggota.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');">
                                     @csrf
                                     @method('DELETE')
                                     <button type="submit" class="text-sm bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded transition">Hapus</button>
                                 </form>

                                </td>
                            </tr>
                        @empty
                            <!-- Ini akan muncul jika database benar-benar kosong -->
                            <tr>
                                <td class="py-6 px-4 border-b text-center text-gray-500 italic" colspan="4">
                                    Belum ada data anggota. Silakan klik tombol "Tambah Anggota Baru".
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>