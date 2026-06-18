<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Analisis Keputusan (Metode TOPSIS)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(isset($error))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded" role="alert">
                    <p class="font-bold">Peringatan Sistem</p>
                    <p>{{ $error }} Silakan tambahkan data inventaris terlebih dahulu.</p>
                </div>
            @else
                
                @if(count($hasil_akhir) > 0)
                    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-500 p-6 mb-8 shadow-md rounded-r-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-yellow-800 mb-2 flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                    Rekomendasi Prioritas Utama
                                </h3>
                                <p class="text-gray-700">Berdasarkan kalkulasi Kriteria Kondisi, Usia, dan Biaya, sistem merekomendasikan tindakan segera untuk:</p>
                                <p class="text-3xl font-black text-gray-900 mt-2 uppercase">{{ $hasil_akhir[0]['barang']->nama_barang }}</p>
                                <p class="text-sm font-semibold text-gray-500 mt-1">Kode: {{ $hasil_akhir[0]['barang']->kode_barang }} | Kategori: {{ $hasil_akhir[0]['barang']->kategori }}</p>
                            </div>
                            <div class="text-right hidden md:block">
                                <p class="text-sm text-yellow-700 font-bold uppercase tracking-wider">Nilai Preferensi (V)</p>
                                <p class="text-5xl font-black text-yellow-600">{{ number_format($hasil_akhir[0]['nilai_preferensi'], 4) }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-gray-800">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Peringkat Kelayakan Keseluruhan</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse">
                            <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                                <tr>
                                    <th class="py-3 px-4 text-center font-bold">Rank</th>
                                    <th class="py-3 px-4 text-left font-bold">Nama Barang</th>
                                    <th class="py-3 px-4 text-center font-bold">Kondisi</th>
                                    <th class="py-3 px-4 text-center font-bold">Usia</th>
                                    <th class="py-3 px-4 text-right font-bold">Est. Harga</th>
                                    <th class="py-3 px-4 text-center font-bold bg-yellow-100 text-yellow-800">Nilai Akhir (V)</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach($hasil_akhir as $index => $hasil)
                                    <tr class="border-b hover:bg-gray-50 {{ $index == 0 ? 'bg-yellow-50 font-semibold' : '' }}">
                                        <td class="py-3 px-4 text-center">
                                            @if($index == 0)
                                                <span class="bg-yellow-500 text-white rounded-full w-8 h-8 flex items-center justify-center mx-auto font-bold shadow">1</span>
                                            @else
                                                <span class="text-gray-500 font-bold">{{ $index + 1 }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            {{ $hasil['barang']->nama_barang }}
                                            <div class="text-xs text-gray-400">{{ $hasil['barang']->kode_barang }}</div>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="px-2 py-1 rounded text-xs font-bold 
                                                {{ $hasil['barang']->kondisi == 'Bagus' ? 'bg-green-100 text-green-700' : ($hasil['barang']->kondisi == 'Rusak Ringan' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                                {{ $hasil['barang']->kondisi }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">{{ date('Y') - $hasil['barang']->tahun_perolehan }} Thn</td>
                                        <td class="py-3 px-4 text-right">Rp {{ number_format($hasil['barang']->estimasi_harga, 0, ',', '.') }}</td>
                                        <td class="py-3 px-4 text-center font-black {{ $index == 0 ? 'text-yellow-600' : 'text-gray-700' }}">
                                            {{ number_format($hasil['nilai_preferensi'], 4) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @endif

        </div>
    </div>
</x-app-layout>