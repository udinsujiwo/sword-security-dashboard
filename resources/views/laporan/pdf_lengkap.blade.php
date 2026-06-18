<!DOCTYPE html>
<html>
<head>
    <title>Laporan Lengkap Aktivitas Keamanan - Sword Security</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 4px 0 0; color: #555; font-size: 11px; }
        
        .section-title { font-size: 12px; font-weight: bold; background-color: #1e293b; color: #fff; padding: 6px 10px; margin-top: 20px; margin-bottom: 8px; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #666; padding: 6px 8px; text-align: left; }
        th { background-color: #f1f5f9; text-transform: uppercase; font-size: 10px; font-weight: bold; }
        
        .text-center { text-align: center; }
        .badge-aman { color: #15803d; font-weight: bold; }
        .badge-kendala { color: #b91c1c; font-weight: bold; }
        .nihil { text-align: center; font-style: italic; color: #666; padding: 15px; border: 1px dashed #999; }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN LENGKAP AKTIVITAS & SITUASI KEAMANAN</h2>
        <p><strong>SWORD SECURITY COMMAND CENTER</strong></p>
        <p>Periode Tanggal: {{ $tanggalPilihan ? \Carbon\Carbon::parse($tanggalPilihan)->format('d F Y') : 'Semua Riwayat Laporan' }}</p>
        <p style="font-size: 9px; color: #888;">Dicetak otomatis pada: {{ \Carbon\Carbon::now()->format('d M Y H:i') }} WIB</p>
    </div>

    <div class="section-title">I. LAPORAN KEJADIAN / INSIDEN MENONJOL</div>
    @if($laporanKejadian->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="12%" class="text-center">Waktu</th>
                    <th width="18%">Pelapor</th>
                    <th width="20%">Jenis Kejadian</th>
                    <th width="50%">Kronologi & Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporanKejadian as $k)
                <tr>
                    <td class="text-center">{{ $k->waktu_kejadian }}</td>
                    <td style="text-transform: uppercase;">{{ $k->user->name }}</td>
                    <td style="font-weight: bold; color: #b91c1c;">{{ $k->jenis_kejadian }}</td>
                    <td>
                        <strong>Kronologi:</strong> {{ $k->kronologi }}
                        @if($k->tindakan_diambil)
                            <br><span style="color: #555; font-size: 10px;"><strong>Tindakan Diambil:</strong> {{ $k->tindakan_diambil }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="nihil">N I H I L (Tidak ada kejadian/insiden menonjol pada tanggal ini)</div>
    @endif


    <div class="section-title">II. JURNAL AKTIVITAS PATROLI RUTIN</div>
    @if($laporanHarian->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="12%" class="text-center">Waktu</th>
                    <th width="18%">Petugas</th>
                    <th width="55%">Uraian Kegiatan Patroli</th>
                    <th width="15%" class="text-center">Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporanHarian as $l)
                <tr>
                    <td class="text-center">{{ $l->waktu_laporan }}</td>
                    <td style="text-transform: uppercase;">{{ $l->user->name }}</td>
                    <td>{{ $l->uraian_kegiatan }}</td>
                    <td class="text-center">
                        <span class="{{ $l->kondisi == 'Aman' ? 'badge-aman' : 'badge-kendala' }}">
                            {{ strtoupper($l->kondisi) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="nihil">Tidak ada riwayat aktivitas patroli tercatat.</div>
    @endif

</body>
</html>