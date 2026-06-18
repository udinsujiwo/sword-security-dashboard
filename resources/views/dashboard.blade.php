<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Command Center Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-l-4 border-indigo-600">
                <div class="p-6 text-gray-900 font-semibold text-lg">
                    Selamat bertugas, {{ Auth::user()->name }}! Ringkasan situasi operasional hari ini.
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 border-b-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-bold uppercase">Total Personel Aktif</div>
                    <div class="text-4xl font-black text-gray-800 mt-2">{{ $total_anggota }} <span class="text-lg text-gray-500 font-normal">Orang</span></div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-b-4 border-green-500">
                    <div class="text-gray-500 text-sm font-bold uppercase">Laporan Patroli Hari Ini</div>
                    <div class="text-4xl font-black text-gray-800 mt-2">{{ $laporan_hari_ini }} <span class="text-lg text-gray-500 font-normal">Laporan</span></div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-b-4 border-red-500">
                    <div class="text-gray-500 text-sm font-bold uppercase">Total Insiden Bulan Ini</div>
                    <div class="text-4xl font-black text-red-600 mt-2">{{ $kejadian_bulan_ini }} <span class="text-lg text-gray-500 font-normal">Kejadian</span></div>
                </div>
            </div>

            @if(auth()->user()->role == 'supervisor')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-yellow-500 px-6 py-4">
                        <h3 class="font-bold text-white text-lg">Tindakan Prioritas Sistem (TOPSIS)</h3>
                    </div>
                    <div class="p-6">
                        @if($barang_prioritas)
                            <p class="text-gray-600 mb-4">Sistem mendeteksi aset berikut memerlukan tindakan segera (perbaikan/penggantian):</p>
                            <div class="bg-yellow-50 border border-yellow-200 rounded p-4 text-center mb-4">
                                <h4 class="text-2xl font-black text-yellow-800 uppercase">{{ $barang_prioritas->nama_barang }}</h4>
                                <p class="text-sm font-bold text-yellow-600 mt-1">Kondisi: {{ $barang_prioritas->kondisi }}</p>
                            </div>
                            <a href="{{ route('topsis.index') }}" class="text-yellow-600 hover:text-yellow-800 font-bold text-sm underline">Lihat Laporan Analisis Lengkap &rarr;</a>
                        @else
                            <p class="text-gray-500 italic text-center py-4">Belum ada data inventaris untuk dianalisis.</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                        <h3 class="font-bold text-white text-lg">Top Personel Bulan Ini (SAW)</h3>
                        <svg class="w-6 h-6 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                    <div class="p-6">
                        @if($pegawai_terbaik)
                            <div class="flex items-center mb-5">
                                <div class="bg-indigo-100 text-indigo-700 rounded-full w-16 h-16 flex items-center justify-center font-black text-2xl shadow-inner mr-4">
                                    {{ strtoupper(substr($pegawai_terbaik['user']->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="text-2xl font-black text-gray-800">{{ $pegawai_terbaik['user']->name }}</h4>
                                    <p class="text-sm font-bold text-indigo-600 mt-1 uppercase">NIP: {{ $pegawai_terbaik['user']->id }} | {{ $pegawai_terbaik['user']->role }}</p>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded border p-4 flex justify-between items-center mb-4">
                                <span class="text-gray-600 font-semibold">Skor Evaluasi (V)</span>
                                <span class="text-2xl font-black text-indigo-700">{{ number_format($pegawai_terbaik['nilai'], 4) }}</span>
                            </div>
                            <a href="{{ route('saw.index') }}" class="text-indigo-600 hover:text-indigo-800 font-bold text-sm underline">Lihat Papan Peringkat Lengkap &rarr;</a>
                        @else
                            <div class="flex flex-col items-center justify-center h-32 bg-gray-50 border-2 border-dashed border-gray-200 rounded">
                                <p class="text-gray-500 font-semibold text-center">Belum ada data evaluasi kinerja.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            </div>
    </div>
</x-app-layout>