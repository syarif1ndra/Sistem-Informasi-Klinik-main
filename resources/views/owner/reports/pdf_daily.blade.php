<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Harian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary-box {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .summary-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 40px;
            font-size: 10px;
            text-align: center;
            color: #999;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="title">LAPORAN TRANSAKSI HARIAN KLINIK</div>
        <div class="subtitle">Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
        </div>
        @if($practitionerId != 'all')
            <div class="subtitle">
                Praktisi: {{ collect($practitioners)->where('id', $practitionerId)->first()->name ?? '-' }}
            </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Tanggal</th>
                <th>Pasien</th>
                <th>Praktisi</th>
                <th class="text-center">Metode</th>
                <th class="text-right">Jumlah Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $trx)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $trx->created_at->translatedFormat('d M Y H:i') }}</td>
                    <td>{{ $trx->patient->name ?? '-' }}</td>
                    <td>{{ $trx->handledBy->name ?? '-' }}</td>
                    <td class="text-center">{{ $trx->payment_method == 'cash' ? 'UMUM' : strtoupper($trx->payment_method) }}
                    </td>
                    <td class="text-right">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total Pendapatan Transaksi</th>
                <th class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="5" class="text-right">Total Pendapatan Klinik Bersih</th>
                <th class="text-right">Rp {{ number_format($totalClinicRevenue, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="5" class="text-right">Total Pendapatan Medis Bersih</th>
                <th class="text-right">Rp {{ number_format($totalMedicalRevenue, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 50px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; width: 70%;"></td>
                <td style="border: none; text-align: center;">
                    Natar, {{ now()->translatedFormat('d F Y') }}<br>
                    Owner,<br><br><br><br>
                    <strong>({{ auth()->user()->name }})</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }}
    </div>

</body>

</html>