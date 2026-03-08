<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Dokter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .clinic-name {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #db2777;
            /* pink-600 */
        }

        .clinic-address {
            margin: 5px 0;
            font-size: 12px;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 3px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table.data-table th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #374151;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .summary-box {
            float: right;
            width: 300px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9fafb;
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .signature {
            margin-top: 80px;
            text-align: right;
            padding-right: 50px;
        }

        .badge-paid {
            color: #059669;
            font-weight: bold;
        }

        .badge-unpaid {
            color: #dc2626;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="clinic-name">KLINIK BIDAN SITI HAJAR</h1>
        <p class="clinic-address">Kp. Cibuntu RT.04 / RW.04, Desa Bojong, Kec. Karangtengah, Kab. Cianjur</p>
        <p class="clinic-address">No. Izin Klinik: 449/194/Klinik/2023 | Telp: 0812-XXXX-XXXX</p>
    </div>

    <div class="report-title">
        LAPORAN KEUANGAN DOKTER
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Nama Dokter</strong></td>
            <td width="2%">:</td>
            <td>{{ auth()->user()->name }}</td>
            <td width="15%"><strong>Tanggal Cetak</strong></td>
            <td width="2%">:</td>
            <td>{{ date('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Periode</strong></td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="20%">Tanggal</th>
                <th width="35%">Nama Pasien</th>
                <th width="20%">Metode</th>
                <th width="20%" class="text-right">Jumlah Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $trx)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                    <td>{{ $trx->patient->name ?? '-' }}</td>
                    <td>{{ $trx->payment_method == 'cash' ? 'UMUM' : strtoupper($trx->payment_method) }}</td>
                    <td class="text-right">
                        @php
                            $serviceTotal = $trx->items->where('item_type', 'App\Models\Service')->sum('subtotal');
                        @endphp
                        Rp {{ number_format($serviceTotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total Jasa Medis (Lunas)</th>
                <th class="text-right">Rp {{ number_format($totalRevenue * 2, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="4" class="text-right">Pendapatan Anda (50%)</th>
                <th class="text-right" style="color: #db2777;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 50px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; width: 70%;"></td>
                <td style="border: none; text-align: center;">
                    Cianjur, {{ now()->translatedFormat('d F Y') }}<br>
                    Dokter Pemeriksa,<br><br><br><br>
                    <strong>({{ auth()->user()->name }})</strong>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>