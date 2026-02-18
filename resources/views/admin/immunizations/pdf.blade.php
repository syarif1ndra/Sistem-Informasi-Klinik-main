<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Imunisasi</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 10pt;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
        }

        .header p {
            margin: 5px 0;
            font-size: 10pt;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Bidan Siti Hajar</h1>
        <p>Jl. Raya, Merak Batin, Natar, Lampung</p>
        <p>Laporan Data Imunisasi - {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Anak</th>
                <th>Nama Orang Tua</th>
                <th>Alamat</th>
                <th>Tanggal Imunisasi</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($immunizations as $index => $record)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $record->child_name }}</td>
                    <td>{{ $record->parent_name }}</td>
                    <td>{{ $record->address }}</td>
                    <td style="text-align: center;">
                        {{ \Carbon\Carbon::parse($record->immunization_date)->translatedFormat('d F Y') }}</td>
                    <td>{{ $record->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>