<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold; font-size: 14pt;">LAPORAN DATA KELAHIRAN</th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold;">Tanggal:
                {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Nama Bayi</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Jenis Kelamin</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Tanggal Lahir</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Jam Lahir</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Nama Ibu</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Nama Ayah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($birthRecords as $index => $record)
            <tr>
                <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000000;">{{ $record->baby_name }}</td>
                <td style="border: 1px solid #000000; text-align: center;">
                    {{ $record->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td style="border: 1px solid #000000; text-align: center;">
                    {{ \Carbon\Carbon::parse($record->birth_date)->translatedFormat('d F Y') }}</td>
                <td style="border: 1px solid #000000; text-align: center;">
                    {{ \Carbon\Carbon::parse($record->birth_time)->format('H:i') }} WIB</td>
                <td style="border: 1px solid #000000;">{{ $record->mother_name }}</td>
                <td style="border: 1px solid #000000;">{{ $record->father_name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>