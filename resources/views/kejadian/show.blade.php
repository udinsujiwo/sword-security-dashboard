<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rincian Laporan Insiden') }}
            </h2>
            <a href="{{ route('kejadian.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-red-600">
                <div class="p-8">
                    
                    <div class="border-b-2 border-gray-200 pb-4 mb-6 text-center">
                        <h3 class="text-2xl font-black text-gray-800 uppercase tracking-widest">Berita Acara Kejadian</h3>
                        <p class="text-gray-500">Nomor Referensi: INC-{{ date('Ymd', strtotime($kejadian->tanggal_kejadian)) }}-{{ str_pad($kejadian->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <div>
                            <p class="text-sm text-gray-500 font-bold mb-1">Dilaporkan Oleh:</p>
                            <p class="text-lg text-gray-900 font-semibold">{{ $kejadian->user->name ?? 'User Tidak Diketahui' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-bold mb-1">Kategori Insiden:</p>
                            <p class="text-lg text-red-600 font-black uppercase">{{ $kejadian->jenis_kejadian }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-bold mb-1">Tanggal Kejadian:</p>
                            <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($kejadian->tanggal_kejadian)->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-bold mb-1">Waktu Kejadian:</p>
                            <p class="text-gray-900 font-medium">{{ $kejadian->waktu_kejadian }} WIB</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">Kronologi Kejadian</h4>
                        <div class="bg-white p-4 border border-gray-200 rounded text-gray-700 leading-relaxed text-justify whitespace-pre-wrap">{{ $kejadian->kronologi }}</div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">Tindakan Penyelesaian</h4>
                        <div class="bg-blue-50 p-4 border border-blue-200 rounded text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $kejadian->tindakan_diambil }}</div>
                    </div>

                    <div>
                        <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">Dokumentasi Foto</h4>
                        @if($kejadian->foto_kejadian)
                            <div class="mt-4 border p-2 rounded inline-block">
                                <img src="{{ asset('storage/kejadian/' . $kejadian->foto_kejadian) }}" alt="Foto Insiden" class="max-w-full h-auto max-h-96 rounded shadow-sm">
                            </div>
                        @else
                            <div class="bg-gray-100 p-6 rounded text-center text-gray-500 italic border border-gray-200">
                                Tidak ada lampiran foto untuk kejadian ini.
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>