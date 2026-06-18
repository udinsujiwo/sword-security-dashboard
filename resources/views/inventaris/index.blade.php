<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Aset & Inventaris') }}
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
                    <div>
                        <h3 class="text-lg font-bold text-indigo-700">Daftar Barang Operasional</h3>
                        <p class="text-sm text-gray-500">Data ini akan digunakan untuk analisis metode TOPSIS.</p>
                    </div>
                    @if(auth()->user()->role == 'supervisor')
                    <a href="{{ route('inventaris.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all">
                        + Tambah Barang
                    </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-slate-800 text-white text-sm uppercase">
                            <tr>
                                <th class="py-3 px-4 text-left">Kode & Nama</th>
                                <th class="py-3 px-4 text-center">Kategori</th>
                                <th class="py-3 px-4 text-center">Jml</th>
                                <th class="py-3 px-4 text-center">Kondisi</th>
                                <th class="py-3 px-4 text-right">Estimasi Harga (Rp)</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($inventaris as $inv)
                            <tr class="border-b hover:bg-indigo-50">
                                <td class="py-3 px-4">
                                    <div class="font-bold text-gray-900">{{ $inv->nama_barang }}</div>
                                    <div class="text-xs text-gray-500">{{ $inv->kode_barang }} | Thn: {{ $inv->tahun_perolehan }}</div>
                                </td>
                                <td class="py-3 px-4 text-center">{{ $inv->kategori }}</td>
                                <td class="py-3 px-4 text-center font-bold">{{ $inv->jumlah }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        {{ $inv->kondisi == 'Bagus' ? 'bg-green-100 text-green-700' : ($inv->kondisi == 'Rusak Ringan' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $inv->kondisi }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right font-medium text-gray-600">
                                    {{ number_format($inv->estimasi_harga, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        @if(auth()->user()->role == 'supervisor')
                                     <a href="{{ route('inventaris.edit', $inv->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-bold py-1 px-3 rounded">
                                         Edit
                                    </a>
                                    @endif
        
                                <form action="{{ route('inventaris.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus aset ini dari inventaris?');">
                                    @csrf
                                     @method('DELETE')
                                     @if(auth()->user()->role == 'supervisor')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded">
                                        Hapus
                                    </button>
                                    @endif
                                </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center italic text-gray-400">Belum ada data inventaris.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>