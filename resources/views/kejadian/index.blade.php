<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Insiden / Kejadian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <span class="block sm:inline font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-red-600">Catatan Insiden & Pelanggaran</h3>
                    <a href="{{ route('kejadian.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all">
                        + Input Kejadian Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-slate-800 text-white text-sm uppercase">
                            <tr>
                                <th class="py-3 px-4 text-left">Waktu & Pelapor</th>
                                <th class="py-3 px-4 text-left">Jenis Insiden</th>
                                <th class="py-3 px-4 text-left">Kronologi Singkat</th>
                                <th class="py-3 px-4 text-center">Foto Bukti</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($kejadian as $k)
                            <tr class="border-b hover:bg-red-50">
                                <td class="py-3 px-4">
                                    <div class="font-bold">{{ $k->tanggal_kejadian }}</div>
                                    <div class="text-xs text-gray-500">{{ $k->waktu_kejadian }} - {{ $k->user->name }}</div>
                                </td>
                                <td class="py-3 px-4 font-semibold text-red-600">{{ $k->jenis_kejadian }}</td>
                                <td class="py-3 px-4 max-w-xs truncate" title="{{ $k->kronologi }}">{{ $k->kronologi }}</td>
                                <td class="py-3 px-4 text-center">
                                    @if($k->foto_kejadian)
                                        <a href="{{ asset('storage/kejadian/' . $k->foto_kejadian) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline font-semibold">Lihat</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('kejadian.edit', $k->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-bold py-1 px-3 rounded">Edit</a>
                                        <a href="{{ route('kejadian.show', $k->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded">Detail</a>
                                        <form action="{{ route('kejadian.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus data kejadian ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center italic text-gray-400">Belum ada catatan kejadian / insiden.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>