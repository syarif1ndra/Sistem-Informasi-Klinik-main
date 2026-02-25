<table>
    <thead>
        <tr>
            <th colspan="4" style="font-size: 16px; font-weight: bold;">LAPORAN RINGKASAN PERFORMA KLINIK</th>
        </tr>
        <tr>
            <th colspan="4" style="font-style: italic;">Periode:
                {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
            </th>
        </tr>
        <tr></tr>
    </thead>
    <tbody>
        <!-- Summary Section -->
        <tr>
            <th colspan="4" style="background-color: #f3f4f6; font-weight: bold;">RINGKASAN METRIK</th>
        </tr>
        <tr>
            <td>Total Transaksi Terfilter</td>
            <td>{{ $totalTransaksi }}</td>
            <td>Pendapatan Hari Ini</td>
            <td>Rp {{ number_format($totalPendapatanHariIni, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Pasien Hari Ini</td>
            <td>{{ $totalPasienHariIni }}</td>
            <td>Pendapatan Bulan Ini</td>
            <td>Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kunjungan Bulan Ini</td>
            <td>{{ $totalKunjunganBulanIni }}</td>
            <td>Total Obat Terjual (Periode)</td>
            <td>{{ $totalObatTerjual }} pcs</td>
        </tr>
        <tr></tr>

        <!-- Latest Transactions -->
        <tr>
            <th colspan="6" style="background-color: #f3f4f6; font-weight: bold;">10 TRANSAKSI TERBARU</th>
        </tr>
        <tr>
            <th style="font-weight: bold;">ID Transaksi</th>
            <th style="font-weight: bold;">Tanggal</th>
            <th style="font-weight: bold;">Nama Pasien</th>
            <th style="font-weight: bold;">Metode Pembayaran</th>
            <th style="font-weight: bold;">Total Pembayaran</th>
            <th style="font-weight: bold;">Status</th>
        </tr>
        @foreach($latestTransactions as $trx)
            <tr>
                <td>{{ $trx->id }}</td>
                <td>{{ $trx->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $trx->patient->name ?? '-' }}</td>
                <td>{{ strtoupper($trx->payment_method) }}</td>
                <td>Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                <td>{{ $trx->status == 'paid' ? 'LUNAS' : 'BELUM LUNAS' }}</td>
            </tr>
        @endforeach
        <tr></tr>

        <!-- Warning Section -->
        <tr>
            <th colspan="3" style="background-color: #fee2e2; font-weight: bold; color: #b91c1c;">PERINGATAN STOK OBAT
                MENIPIS (<= 10)</th>
        </tr>
        <tr>
            <th style="font-weight: bold;">Nama Obat</th>
            <th style="font-weight: bold;">Sisa Stok</th>
        </tr>
        @foreach($lowStockMedicines as $med)
            <tr>
                <td>{{ $med->name }}</td>
                <td>{{ $med->stock }}</td>
            </tr>
        @endforeach
        <tr></tr>

        <tr>
            <th colspan="3" style="background-color: #fee2e2; font-weight: bold; color: #b91c1c;">PERINGATAN OBAT MASA
                KADALUARSA (< 30 Hari)</th>
        </tr>
        <tr>
            <th style="font-weight: bold;">Nama Obat</th>
            <th style="font-weight: bold;">Tanggal Kadaluarsa</th>
        </tr>
        @foreach($expiredMedicines as $med)
            <tr>
                <td>{{ $med->name }}</td>
                <td>{{ \Carbon\Carbon::parse($med->expired_date)->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>