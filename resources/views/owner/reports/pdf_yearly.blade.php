<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Tahunan</title>
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
        <div class="title">LAPORAN TRANSAKSI TAHUNAN KLINIK</div>
        <div class="subtitle">Tahun: {{ $year }}</div>
        @if($practitionerId != 'all')
            <div class="subtitle">
                Praktisi: {{ $practitioners->where('id', $practitionerId)->first()->name ?? '-' }}
            </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Bulan</th>
                <th class="text-center">Jumlah Transaksi</th>
                <th class="text-right">Jumlah Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $trx)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::create()->month($trx->label_month)->translatedFormat('F') }}</td>
                    <td class="text-center">{{ $trx->total_count }}</td>
                    <td class="text-right">Rp {{ number_format($trx->total_revenue, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data transaksi pada tahun ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total Pendapatan Transaksi</th>
                <th class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Total Pendapatan Klinik Bersih</th>
                <th class="text-right">Rp {{ number_format($totalClinicRevenue, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Total Pendapatan Medis Bersih</th>
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