<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Penilaian Kinerja Karyawan (Metode SAW)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(isset($error))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded">
                    <p class="font-bold">Informasi Sistem</p>
                    <p>{{ $error }}</p>
                </div>
            @elseif(count($hasil_akhir) == 0)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 shadow-sm rounded">
                    <p class="font-bold">Data Belum Cukup</p>
                    <p>Anggota satpam belum memiliki riwayat absensi atau laporan. Sistem belum bisa melakukan penilaian.</p>
                </div>
            @else
                
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg mb-8 overflow-hidden">
                    <div class="p-6 md:p-8 text-white flex flex-col md:flex-row items-center justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="bg-yellow-400 text-indigo-900 rounded-full w-16 h-16 flex items-center justify-center font-black text-3xl shadow-lg border-4 border-white mr-6">
                                1
                            </div>
                            <div>
                                <p class="text-indigo-100 font-semibold uppercase tracking-wider text-sm mb-1">Karyawan Terbaik Bulan Ini</p>
                                <h3 class="text-3xl font-black">{{ $hasil_akhir[0]['user']->name }}</h3>
                                <p class="text-indigo-200 mt-1">NIP/ID: {{ $hasil_akhir[0]['user']->id }} | Role: {{ strtoupper($hasil_akhir[0]['user']->role) }}</p>
                            </div>
                        </div>
                        <div class="text-center bg-white bg-opacity-20 rounded-lg p-4 w-full md:w-auto">
                            <p class="text-indigo-100 text-sm font-bold uppercase tracking-wider mb-1">Skor Akhir (V)</p>
                            <p class="text-4xl font-black text-white">{{ number_format($hasil_akhir[0]['nilai_akhir'], 4) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-indigo-500">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Papan Peringkat Kinerja Keseluruhan</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse">
                            <thead class="bg-slate-800 text-white text-sm uppercase">
                                <tr>
                                    <th class="py-3 px-4 text-center font-bold">Rank</th>
                                    <th class="py-3 px-4 text-left font-bold">Nama Petugas</th>
                                    <th class="py-3 px-4 text-center font-bold">C1: Kehadiran<br><span class="text-xs text-indigo-300">(Benefit 40%)</span></th>
                                    <th class="py-3 px-4 text-center font-bold">C2: Patroli<br><span class="text-xs text-indigo-300">(Benefit 40%)</span></th>
                                    <th class="py-3 px-4 text-center font-bold">C3: Insiden<br><span class="text-xs text-indigo-300">(Benefit 20%)</span></th>
                                    <th class="py-3 px-4 text-center font-bold bg-indigo-700">Nilai Akhir (V)</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach($hasil_akhir as $index => $hasil)
                                    <tr class="border-b hover:bg-indigo-50 {{ $index == 0 ? 'bg-indigo-50 font-semibold' : '' }}">
                                        <td class="py-3 px-4 text-center">
                                            @if($index == 0)
                                                <span class="text-yellow-500 font-black text-lg">🏆 1</span>
                                            @else
                                                <span class="text-gray-500 font-bold">{{ $index + 1 }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-gray-900 font-bold">
                                            {{ $hasil['user']->name }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full font-bold text-xs">{{ $hasil['total_absen'] }} Hari</span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full font-bold text-xs">{{ $hasil['total_laporan'] }} Giat</span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full font-bold text-xs">{{ $hasil['total_kejadian'] }} Insiden</span>
                                        </td>
                                        <td class="py-3 px-4 text-center font-black {{ $index == 0 ? 'text-indigo-600 text-lg' : 'text-gray-700' }}">
                                            {{ number_format($hasil['nilai_akhir'], 4) }}
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