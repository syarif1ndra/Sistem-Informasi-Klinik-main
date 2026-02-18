<table>
    <thead>
        <tr>
            <th colspan="5" style="text-align: center; font-weight: bold; font-size: 14pt;">LAPORAN TRANSAKSI BULANAN
            </th>
        </tr>
        <tr>
            <th colspan="5" style="text-align: center; font-weight: bold;">Periode:
                {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Tanggal</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Nama Pasien</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Total Tagihan</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $index => $trx)
            <tr>
                <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000000; text-align: center;">
                    {{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                <td style="border: 1px solid #000000;">{{ $trx->patient->name }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ $trx->total_amount }}</td>
                <td style="border: 1px solid #000000; text-align: center;">
                    {{ $trx->status == 'paid' ? 'Lunas' : 'Belum Lunas' }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="border: 1px solid #000000; font-weight: bold; text-align: right;">Total Pendapatan
            </td>
            <td style="border: 1px solid #000000; font-weight: bold; text-align: right;">
                {{ $transactions->sum('total_amount') }}</td>
            <td style="border: 1px solid #000000;"></td>
        </tr>
    </tbody>
</table>