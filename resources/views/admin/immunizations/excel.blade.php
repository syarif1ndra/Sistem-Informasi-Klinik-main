<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold; font-size: 14pt;">LAPORAN DATA IMUNISASI</th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold;">Tanggal:
                {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Nama Anak</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">NIK Anak</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Nama Orang Tua</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Alamat</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Tanggal Imunisasi</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center;">Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($immunizations as $index => $record)
            <tr>
                <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000000;">{{ $record->child_name }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ $record->child_nik ?? '-' }}</td>
                <td style="border: 1px solid #000000;">{{ $record->parent_name }}</td>
                <td style="border: 1px solid #000000;">{{ $record->address }}</td>
                <td style="border: 1px solid #000000; text-align: center;">
                    {{ \Carbon\Carbon::parse($record->immunization_date)->translatedFormat('d F Y') }}</td>
                <td style="border: 1px solid #000000;">{{ $record->notes }}</td>
            </tr>
        @endforeach
    </tbody>
</table>