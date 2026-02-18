<table>
    <thead>
        <tr>
            <th colspan="6" style="text-align: center; font-weight: bold; font-size: 14pt;">LAPORAN DATA PASIEN</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center; font-weight: bold;">Tanggal:
                {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Nama Pasien</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Alamat</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">No. HP</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Jenis Kelamin</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Tanggal Lahir</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patients as $index => $patient)
            <tr>
                <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000000;">{{ $patient->name }}</td>
                <td style="border: 1px solid #000000;">{{ $patient->address }}</td>
                <td style="border: 1px solid #000000;">{{ $patient->phone }}</td>
                <td style="border: 1px solid #000000; text-align: center;">
                    {{ $patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td style="border: 1px solid #000000; text-align: center;">
                    {{ \Carbon\Carbon::parse($patient->dob)->translatedFormat('d F Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>