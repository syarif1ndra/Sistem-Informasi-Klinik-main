<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiket Obat - {{ $prescription->patient->name }}</title>
    <style>
        @page {
            size: 80mm 60mm;
            /* Standar ukuran etiket obat */
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 4mm;
            width: 72mm;
            /* 80mm - 8mm padding */
            height: 52mm;
            /* 60mm - 8mm padding */
            box-sizing: border-box;
            background-color: white;
            color: black;
            font-size: 10pt;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid black;
            padding-bottom: 2mm;
            margin-bottom: 2mm;
        }

        .header h1 {
            font-size: 11pt;
            font-weight: bold;
            margin: 0 0 1mm 0;
        }

        .header p {
            font-size: 7pt;
            margin: 0;
        }

        .content {
            flex-grow: 1;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5mm;
            font-size: 9pt;
        }

        .label {
            width: 30%;
        }

        .value {
            width: 68%;
            font-weight: bold;
        }

        .medicine-name {
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            margin: 2mm 0;
            padding: 1.5mm 0;
            border-top: 1px dashed #ccc;
            border-bottom: 1px dashed #ccc;
        }

        .instructions {
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            margin-top: 2mm;
        }

        .footer {
            font-size: 7pt;
            text-align: center;
            border-top: 1px solid black;
            padding-top: 1mm;
            font-style: italic;
        }

        /* Opsi cetak (hidden saat diprint) */
        @media print {
            .no-print {
                display: none !important;
            }
        }

        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: sans-serif;
        }

        .btn-print {
            background: #ec4899;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-print:hover {
            background: #db2777;
        }
    </style>
</head>

<body>

    <div class="no-print print-controls">
        <p style="margin-top:0;font-size:14px;font-weight:bold;">Preview Etiket</p>
        <p style="font-size:12px;color:#666;margin-bottom:10px;">Gunakan kertas stiker ukuran 80x60mm</p>
        <button class="btn-print" onclick="window.print()">Cetak Sekarang</button>
    </div>

    <!-- Area Cetak Etiket -->
    <div class="header">
        <h1>Bidan Siti Hajar</h1>
        <p>Jl. Contoh Alamat No. 123, Kota<br>Telp: 0812-3456-7890</p>
    </div>

    <div class="content">
        <div class="row">
            <div class="label">Tgl Resep</div>
            <div class="value">: {{ $prescription->created_at->format('d/m/Y') }}</div>
        </div>
        <div class="row">
            <div class="label">Nama Pasien</div>
            <div class="value">: {{ Str::limit($prescription->patient->name, 20) }}</div>
        </div>

        <div class="medicine-name">
            {{ $item->medicine->name }}
            <div style="font-size: 8pt; font-weight: normal; margin-top: 1mm;">Qty: {{ $item->quantity }} pcs</div>
        </div>

        <div class="instructions">
            {{ $item->dosage ?: 'Sesuai Anjuran' }}<br>
            <span style="font-size: 8pt; font-weight: normal;">{{ $item->instructions }}</span>
        </div>
    </div>

    <div class="footer">
        Semoga Lekas Sembuh
    </div>

</body>

</html>