<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Petugas Jaga (Absensi)') }}
        </h2>
    </x-slot>
    
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline font-bold">{{ session('success') }}</span>
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline font-bold">{{ session('error') }}</span>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-700">Rekap Kehadiran Hari Ini</h3>
                        
                        <form action="{{ route('absensi.store') }}" method="POST" class="inline-block m-0">
                            @csrf
                            <button type="submit" onclick="return confirm('Anda yakin ingin melakukan Absen Masuk sekarang?')" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block mr-1 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Absen Masuk Sekarang
                            </button>
                        </form>
                        </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full leading-normal">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left font-semibold">Nama Petugas</th>
                                    <th class="py-3 px-4 border-b text-center font-semibold">Tanggal</th>
                                    <th class="py-3 px-4 border-b text-center font-semibold">Shift</th>
                                    <th class="py-3 px-4 border-b text-center font-semibold">Jam Masuk</th>
                                    <th class="py-3 px-4 border-b text-center font-semibold">Status</th>
                                    <th class="py-3 px-4 border-b text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                             @forelse ($absensi as $item)
                                 <tr class="hover:bg-gray-50 transition-colors">
                                     <td class="py-3 px-4 border-b text-gray-800 font-medium">{{ $item->user->name ?? 'User Dihapus' }}</td>
                                     <td class="py-3 px-4 border-b text-center text-gray-600">{{ $item->tanggal }}</td>
                                     <td class="py-3 px-4 border-b text-center text-gray-600 uppercase">{{ $item->shift }}</td>
                                     <td class="py-3 px-4 border-b text-center text-gray-600">{{ $item->waktu_masuk ?? '-' }}</td>
                                     <td class="py-3 px-4 border-b text-center font-bold {{ $item->status_kehadiran == 'Hadir' ? 'text-green-600' : 'text-red-600' }}">{{ $item->status_kehadiran }}</td>
                                     <td class="py-3 px-4 border-b text-center">
                                         <a href="{{ route('absensi.edit', $item->id) }}" class="inline-block text-sm bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded mr-1 transition">Edit</a>
                                         <form action="{{ route('absensi.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data absensi ini?');">
                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" class="text-sm bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded transition">Hapus</button>
                                         </form>
                                     </td>
                                 </tr>
                             @empty
                                 <tr>
                                     <td class="py-6 px-4 border-b text-center text-gray-500 italic" colspan="6">
                                         Belum ada data absensi yang masuk.
                                     </td>
                                 </tr>
                             @endforelse
                         </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>