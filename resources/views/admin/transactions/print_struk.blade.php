<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran #{{ $transaction->id }}</title>
    <style>
        @page {
            margin: 0;
            size: auto;
            /* auto is the initial value */
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 10pt;
            /* Standard thermal paper width (approx 58mm or 80mm) */
            /* We will let the printer driver handle the actual paper width, 
               but max-width helps responsiveness on screen */
            max-width: 80mm;
            margin: 0 auto;
            padding: 5mm;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
        }

        .header p {
            margin: 2px 0;
            font-size: 8pt;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .info {
            font-size: 9pt;
            margin-bottom: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }

        .items th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding: 2px 0;
        }

        .items td {
            padding: 2px 0;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            margin-top: 5px;
            font-size: 9pt;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 8pt;
        }

        @media print {
            body {
                width: 100%;
                /* Let printer handle width */
                max-width: none;
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="header">
        <h1>Bidan Siti Hajar</h1>
        <p>Jl. Raya, Merak Batin, Natar, Lampung</p>
        <p>Telp: (021) 123-4567</p>
    </div>

    <div class="divider"></div>

    <div class="info">
        <div class="info-row">
            <span>No. Transaksi</span>
            <span>#{{ $transaction->id }}</span>
        </div>
        <div class="info-row">
            <span>Tanggal</span>
            <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span>Pasien</span>
            <span>{{ $transaction->patient->name }}</span>
        </div>
        <div class="info-row">
            <span>Metode Bayar</span>
            <span>{{ $transaction->payment_method == 'bpjs' ? 'BPJS' : 'Tunai' }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 45%;">Item</th>
                <th style="width: 20%; text-align: center;">Qty</th>
                <th style="width: 35%;" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="totals">
        <div class="totals-row font-bold">
            <span>Total Tagihan</span>
            <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
        </div>
        <!-- You can add payment details here if recorded (Cash/Card, Change) -->
    </div>

    <div class="footer">
        <p>Terima Kasih atas kunjungan Anda.</p>
        <p>Semoga lekas sembuh.</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Ulang</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup</button>
    </div>

</body>

</html>