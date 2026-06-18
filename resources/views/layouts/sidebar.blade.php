<aside class="flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-slate-900 border-r border-slate-700">
    <div class="flex flex-col mt-2">
        <h4 class="font-bold text-gray-100 uppercase tracking-widest">MANAGEMENT</h4>
        <p class="mt-1 text-xs font-medium text-gray-400">Admin Dashboard</p>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav>
            <a class="flex items-center px-4 py-3 mt-4 text-gray-400 transition-colors duration-300 transform hover:bg-slate-800 hover:text-gray-100 hover:border-l-4 hover:border-blue-500 rounded-lg" href="{{ route('absensi.index') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.092 2.019-.273 3.001m-1.546 2.457A13.944 13.944 0 0112 21c-2.452 0-4.757-.643-6.73-1.78" />
                </svg>
                <span class="mx-4 font-medium text-sm">Absensi</span>
            </a>

            @if(auth()->user()->role == 'supervisor')
            <a class="flex items-center px-4 py-3 mt-4 text-gray-400 transition-colors duration-300 transform hover:bg-slate-800 hover:text-gray-100 hover:border-l-4 hover:border-blue-500 rounded-lg" href="{{ route('anggota.index') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <span class="mx-4 font-medium text-sm">Tambah Anggota</span>
            </a>
            @endif

            <a class="flex items-center px-4 py-3 mt-4 text-gray-400 transition-colors duration-300 transform hover:bg-slate-800 hover:text-gray-100 hover:border-l-4 hover:border-blue-500 rounded-lg" href="{{ route('laporan.index') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="mx-4 font-medium text-sm">Laporan Harian</span>
            </a>

            <a class="flex items-center px-4 py-3 mt-4 text-gray-400 transition-colors duration-300 transform hover:bg-slate-800 hover:text-gray-100 hover:border-l-4 hover:border-blue-500 rounded-lg" href="{{ route('kejadian.index') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="mx-4 font-medium text-sm">Inputan Kejadian</span>
            </a>

            @if(auth()->user()->role == 'supervisor' || auth()->user()->role == 'danru') 
            <a class="flex items-center px-4 py-3 mt-4 text-gray-400 transition-colors duration-300 transform hover:bg-slate-800 hover:text-gray-100 hover:border-l-4 hover:border-blue-500 rounded-lg" href="{{ route('inventaris.index') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <span class="mx-4 font-medium text-sm">Data Inventaris</span>
            </a>
            @endif

            @if(auth()->user()->role == 'supervisor')
            <a class="flex items-center px-4 py-3 mt-4 text-yellow-500 transition-colors duration-300 transform hover:bg-slate-800 hover:text-yellow-400 hover:border-l-4 hover:border-yellow-500 rounded-lg" href="{{ route('topsis.index') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span class="mx-4 font-medium text-sm">Analisis TOPSIS</span>
            </a>

            <a class="flex items-center px-4 py-3 mt-4 text-yellow-500 transition-colors duration-300 transform hover:bg-slate-800 hover:text-yellow-400 hover:border-l-4 hover:border-yellow-500 rounded-lg" href="{{ route('saw.index') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                <span class="mx-4 font-medium text-sm">Penilaian Kinerja (SAW)</span>   
            </a>
            @endif
        </nav>
    </div>
</aside>s