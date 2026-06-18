<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jurnal Laporan Harian') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="block sm:inline font-bold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-8 flex justify-between items-center">
                <h3 class="text-xl font-black text-gray-800 border-l-4 border-blue-500 pl-3">Riwayat Patroli & Uraian Kegiatan</h3>
                
                <div class="flex items-center space-x-3">
                    
                    <form action="{{ route('laporan.pdf') }}" method="GET" target="_blank" class="flex items-center space-x-2 bg-gray-50 border border-gray-200 p-1.5 rounded-lg">
                        <input type="date" name="tanggal" class="border-gray-300 rounded-md shadow-sm text-sm py-1.5 px-2 focus:ring-gray-500 focus:border-gray-500" title="Pilih tanggal Jurnal Harian">
                        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold text-sm py-1.5 px-3 rounded-md transition-all shadow">
                            Cetak Jurnal
                        </button>
                    </form>

                    <form action="{{ route('laporan.lengkap') }}" method="GET" target="_blank" class="flex items-center space-x-2 bg-red-50 border border-red-200 p-1.5 rounded-lg">
                        <input type="date" name="tanggal" class="border-red-300 rounded-md shadow-sm text-sm py-1.5 px-2 focus:ring-red-500 focus:border-red-500" title="Pilih tanggal Laporan Lengkap">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold text-sm py-1.5 px-3 rounded-md shadow transition-all flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak Lengkap
                        </button>
                    </form>

                    <a href="{{ route('laporan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all flex items-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Buat Laporan Baru
                    </a>
                </div>
            </div>

            <div class="space-y-8">
                @forelse($laporan->groupBy('tanggal') as $tanggalLaporan => $kumpulanLaporan)
                    
                    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                        
                        <div class="bg-slate-800 px-6 py-3 flex justify-between items-center">
                            <h4 class="text-white font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Laporan Hari: {{ \Carbon\Carbon::parse($tanggalLaporan)->format('d F Y') }}
                            </h4>
                            <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-inner">
                                {{ $kumpulanLaporan->count() }} Laporan
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse">
                                <thead class="bg-gray-100 text-gray-600 text-xs uppercase font-bold">
                                    <tr>
                                        <th class="py-3 px-6 text-left border-b">Waktu / Petugas</th>
                                        <th class="py-3 px-6 text-left border-b">Uraian Kegiatan</th>
                                        <th class="py-3 px-6 text-center border-b">Kondisi</th>
                                        <th class="py-3 px-6 text-center border-b">Foto Bukti</th>
                                        <th class="py-3 px-6 text-center border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 divide-y divide-gray-200">
                                    @foreach($kumpulanLaporan as $l)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                                        <td class="py-4 px-6 w-1/4">
                                            <div class="font-black text-gray-800 text-lg">{{ $l->waktu_laporan }}</div>
                                            <div class="text-sm font-semibold text-blue-600 mt-1 uppercase">{{ $l->user->name }}</div>
                                        </td>
                                        <td class="py-4 px-6 max-w-md break-words text-sm leading-relaxed">
                                            {{ $l->uraian_kegiatan }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="px-3 py-1.5 rounded-md text-xs font-black uppercase tracking-wider {{ $l->kondisi == 'Aman' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200' }}">
                                                {{ $l->kondisi }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($l->foto_bukti)
                                                <a href="{{ asset('storage/laporan/' . $l->foto_bukti) }}" target="_blank" class="inline-flex items-center gap-1 text-sm bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-800 font-bold py-1.5 px-3 rounded transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    Lihat
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-sm italic">Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('laporan.edit', $l->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-bold py-1.5 px-3 rounded shadow-sm transition">
                                                    Edit
                                                </a>
                                                <form action="{{ route('laporan.destroy', $l->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1.5 px-3 rounded shadow-sm transition">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-lg shadow-sm border border-dashed border-gray-300 p-10 flex flex-col items-center justify-center text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h4 class="text-lg font-bold text-gray-500">Belum Ada Laporan</h4>
                        <p class="text-gray-400 mt-1">Data riwayat patroli akan muncul di sini.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>