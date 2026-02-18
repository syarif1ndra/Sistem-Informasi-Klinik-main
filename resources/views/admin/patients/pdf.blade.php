<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Pasien</title>
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
        <p>Laporan Data Pasien - {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Pasien</th>
                <th>Keluhan</th>
                <th>No. HP</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visits as $index => $visit)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $visit->patient->name ?? '-' }}</td>
                    <td>{{ $visit->complaint ?? '-' }}</td>
                    <td>{{ $visit->patient->phone ?? '-' }}</td>
                    <td style="text-align: center;">{{ ($visit->patient->gender ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </td>
                    <td style="text-align: center;">
                        {{ \Carbon\Carbon::parse($visit->patient->dob ?? now())->translatedFormat('d F Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>