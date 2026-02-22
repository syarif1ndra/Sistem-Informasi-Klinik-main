<!DOCTYPE html>
<html>

<head>
    <title>Laporan Klinik</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: #db2777;
        }

        .period {
            color: #666;
            margin-top: 5px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            background-color: #f3f4f6;
            padding: 5px 10px;
            border-left: 4px solid #db2777;
            margin-bottom: 10px;
        }

        .metrics-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .metrics-table td {
            padding: 8px;
            border: 1px solid #e5e7eb;
            width: 25%;
        }

        .metrics-table .label {
            font-weight: bold;
            color: #4b5563;
            background-color: #f9fafb;
            font-size: 10px;
            text-transform: uppercase;
        }

        .metrics-table .value {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .data-table th,
        .data-table td {
            padding: 6px 8px;
            border: 1px solid #e5e7eb;
            text-align: left;
        }

        .data-table th {
            background-color: #f9fafb;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            color: #4b5563;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="title">Laporan Ringkasan Performa Klinik Bidan Siti Hajar</div>
        <div class="period">Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</div>
        <div class="period" style="font-size: 10px;">Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }}</div>
    </div>

    <!-- Metrics Summary -->
    <div class="section">
        <div class="section-title">Ringkasan Utama</div>
        <table class="metrics-table">
            <tr>
                <td class="label">Total Transaksi</td>
                <td class="value">{{ $totalTransaksi }}</td>
                <td class="label" style="color:#db2777;">Pendapatan Hari Ini</td>
                <td class="value" style="color:#db2777;">Rp {{ number_format($totalPendapatanHariIni, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="label">Pasien Hari Ini</td>
                <td class="value">{{ $totalPasienHariIni }}</td>
                <td class="label" style="color:#db2777;">Pendapatan Bulan Ini</td>
                <td class="value" style="color:#db2777;">Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="label">Kunjungan Bulan Ini</td>
                <td class="value">{{ $totalKunjunganBulanIni }}</td>
                <td class="label">Total Obat Terjual (Periode)</td>
                <td class="value">{{ $totalObatTerjual }} pcs</td>
            </tr>
        </table>
    </div>

    <!-- Data Tables -->
    <div class="section">
        <div class="section-title">10 Transaksi Terbaru</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Nama Pasien</th>
                    <th>Metode</th>
                    <th>Total Pembayaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestTransactions as $trx)
                    <tr>
                        <td>#{{ $trx->id }}</td>
                        <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $trx->patient->name ?? '-' }}</td>
                        <td>{{ strtoupper($trx->payment_method) }}</td>
                        <td class="text-right">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                        <td>{{ $trx->status == 'paid' ? 'LUNAS' : 'BELUM' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="width: 100%; display: table;">
        <div style="display: table-row">
            <div style="display: table-cell; width: 48%; padding-right: 2%;">
                <div class="section-title">Layanan Teratas</div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Layanan</th>
                            <th class="text-right">Frekuensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topServices as $service)
                            <tr>
                                <td>{{ $service->name }}</td>
                                <td class="text-right">{{ $service->total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="display: table-cell; width: 48%; padding-left: 2%;">
                <div class="section-title">Obat Terlaris</div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th class="text-right">Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topMedicines as $medicine)
                            <tr>
                                <td>{{ $medicine->name }}</td>
                                <td class="text-right">{{ $medicine->total }} pcs</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Peringatan Stok -->
    @if($lowStockMedicines->count() > 0 || $expiredMedicines->count() > 0)
        <div class="section" style="page-break-before: always;">
            <div class="section-title" style="border-left-color: #ef4444;">Peringatan Penting</div>

            @if($lowStockMedicines->count() > 0)
                <p style="font-weight: bold; color: #ea580c; margin-bottom: 5px;">* Obat Stok Menipis (<= 10)</p>
                        <table class="data-table" style="margin-bottom: 15px;">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th class="text-right">Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockMedicines as $med)
                                    <tr>
                                        <td>{{ $med->name }}</td>
                                        <td class="text-right" style="color: #ea580c; font-weight: bold;">{{ $med->stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
            @endif

                    @if($expiredMedicines->count() > 0)
                        <p style="font-weight: bold; color: #dc2626; margin-bottom: 5px;">* Obat Mendekati Kadaluarsa / Telah
                            Kadaluarsa</p>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Tgl Kadaluarsa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expiredMedicines as $med)
                                    <tr>
                                        <td>{{ $med->name }}</td>
                                        <td
                                            style="color: {{ \Carbon\Carbon::parse($med->expired_date)->isPast() ? '#dc2626' : '#ea580c' }}; font-weight: bold;">
                                            {{ \Carbon\Carbon::parse($med->expired_date)->translatedFormat('d M Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
        </div>
    @endif

</body>

</html>