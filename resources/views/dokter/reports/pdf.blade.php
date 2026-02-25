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
            <td>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</td>
            <td><strong>Total Pasien</strong></td>
            <td>:</td>
            <td>{{ $totalTransactions }} Pasien</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="12%">Tanggal</th>
                <th width="15%">No. Transaksi</th>
                <th width="20%">Nama Pasien</th>
                <th width="20%">Layanan Diberikan</th>
                <th width="15%" class="text-right">Total Jasa Medis</th>
                <th width="13%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $trx)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                    <td>{{ $trx->transaction_number }}</td>
                    <td>{{ $trx->patient->name ?? '-' }}</td>
                    <td>
                        @php
                            $services = $trx->items->where('item_type', 'App\Models\Service')->map(function ($i) {
                                return $i->item_name; })->implode(', ');
                        @endphp
                        {{ $services ?: '-' }}
                    </td>
                    <td class="text-right">
                        @php
                            $serviceTotal = $trx->items->where('item_type', 'App\Models\Service')->sum('subtotal');
                        @endphp
                        Rp {{ number_format($serviceTotal, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @if($trx->status === 'paid')
                            <span class="badge-paid">Lunas</span>
                        @else
                            <span class="badge-unpaid">Belum Lunas</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <div style="font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
            Ringkasan Pendapatan</div>
        <table width="100%">
            <tr>
                <td>Total Jasa Medis (Lunas)</td>
                <td class="text-right">Rp {{ number_format($totalRevenue * 2, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Milik Klinik (50%)</td>
                <td class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding-top: 5px;">Pendapatan Anda (50%)</td>
                <td class="text-right" style="font-weight: bold; color: #db2777; padding-top: 5px;">Rp
                    {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    <div class="signature">
        <p>Cianjur, {{ date('d F Y') }}</p>
        <p style="margin-bottom: 60px;">Dokter Pemeriksa,</p>
        <p><strong>{{ auth()->user()->name }}</strong></p>
    </div>
</body>

</html>