<!DOCTYPE html>
<html>
<head>
    <title>Jurnal Laporan Harian - Sword Security</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; text-transform: uppercase; font-size: 11px;}
        .date-row { background-color: #e5e7eb; font-weight: bold; font-size: 11px;}
        .text-center { text-align: center; }
        .badge-aman { color: green; font-weight: bold; }
        .badge-bahaya { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>JURNAL LAPORAN HARIAN PATROLI</h2>
        <p><strong>SWORD SECURITY</strong></p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%" class="text-center">Waktu</th>
                <th width="20%">Petugas</th>
                <th width="45%">Uraian Kegiatan</th>
                <th width="20%" class="text-center">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan->groupBy('tanggal') as $tanggalLaporan => $kumpulanLaporan)
                <tr>
                    <td colspan="4" class="date-row">
                        Tanggal Laporan: {{ \Carbon\Carbon::parse($tanggalLaporan)->format('d F Y') }}
                    </td>
                </tr>
                
                @foreach($kumpulanLaporan as $l)
                <tr>
                    <td class="text-center">{{ $l->waktu_laporan }}</td>
                    <td style="text-transform: uppercase;">{{ $l->user->name }}</td>
                    <td>{{ $l->uraian_kegiatan }}</td>
                    <td class="text-center">
                        <span class="{{ $l->kondisi == 'Aman' ? 'badge-aman' : 'badge-bahaya' }}">
                            {{ strtoupper($l->kondisi) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>
</html>