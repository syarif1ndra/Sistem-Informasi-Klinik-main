<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Kelahiran</title>
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
        <p>Laporan Data Kelahiran - {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Bayi</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Jam</th>
                <th>Nama Ibu</th>
                <th>Nama Ayah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($birthRecords as $index => $record)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $record->baby_name }}</td>
                    <td style="text-align: center;">{{ $record->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td style="text-align: center;">
                        {{ \Carbon\Carbon::parse($record->birth_date)->translatedFormat('d F Y') }}</td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($record->birth_time)->format('H:i') }}</td>
                    <td>{{ $record->mother_name }}</td>
                    <td>{{ $record->father_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>