<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Kelahiran</title>
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 1.5cm;
            color: #000;
            font-size: 11pt;
        }

        .container {
            padding: 20px;
            page-break-inside: avoid;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .clinic-name {
            font-size: 16pt;
            font-weight: 700;
            margin-bottom: 4px;
            color: #000;
        }

        .clinic-info {
            font-size: 10pt;
            color: #000;
            margin-top: 2px;
        }

        .title {
            text-align: center;
            margin: 22px 0 16px;
        }

        .title h1 {
            margin: 0;
            font-size: 18pt;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #000;
        }

        .document-number {
            margin-top: 8px;
            font-size: 10pt;
            color: #000;
        }

        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 11pt;
            font-weight: 700;
            color: #000;
            margin-bottom: 10px;
            padding-bottom: 4px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-table td {
            vertical-align: top;
            padding: 4px 6px;
        }

        .label {
            width: 160px;
            font-weight: 600;
            color: #000;
        }

        .value {
            color: #000;
        }

        .note {
            font-size: 10pt;
            line-height: 1.5;
            color: #000;
            text-align: justify;
        }

        .footer-note {
            position: fixed;
            bottom: 1.5cm;
            left: 1.5cm;
            width: 50%;
            font-size: 9pt;
            color: #000;
        }

        .signature {
            position: fixed;
            bottom: 1.5cm;
            right: 1.5cm;
            text-align: right;
        }

        .sign-box {
            width: 220px;
            text-align: center;
        }

        .sign-date {
            margin-bottom: 18px;
            font-size: 10pt;
            color: #000;
        }

        .sign-title {
            font-size: 11pt;
            font-weight: 700;
            margin-bottom: 48px;
            color: #000;
        }

        .sign-name {
            display: inline-block;
            padding-top: 6px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="clinic-name">Bidan Siti Hajar</div>
            <div class="clinic-info">SIPB Nomor: 151/DPMPTSP/SIPB/III/2023</div>
            <div class="clinic-info">Jalan Raya, Merak Batin, Natar, Lampung Selatan  </div>
            <div class="clinic-info">Provinsi Lampung</div>
        </div>

        <div class="title">
            <h1>Surat Keterangan Kelahiran</h1>
            <div class="document-number">
                Nomor: {{ $birthRecord->birth_certificate_number ?? '...../SKK/..../..../20....' }}
            </div>
        </div>

        <div class="section note">
            Yang bertanda tangan di bawah ini,
            <strong>{{ $birthRecord->attendant_name ?? 'Bidan Siti Hajar' }}</strong>,
            dengan ini menerangkan bahwa:
        </div>

        <div class="section">
            <div class="section-title">Data Ibu</div>
            <table class="detail-table">
                <tr>
                    <td class="label">Nama</td>
                    <td class="value">{{ $birthRecord->mother_name }}</td>
                </tr>
                <tr>
                    <td class="label">Umur</td>
                    <td class="value">{{ $birthRecord->mother_age ? $birthRecord->mother_age . ' Tahun' : '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Pekerjaan</td>
                    <td class="value">{{ $birthRecord->mother_job ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td class="value">{{ $birthRecord->mother_address ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Isteri dari</div>
            <table class="detail-table">
                <tr>
                    <td class="label">Nama</td>
                    <td class="value">{{ $birthRecord->father_name }}</td>
                </tr>
                <tr>
                    <td class="label">Umur</td>
                    <td class="value">{{ $birthRecord->father_age ? $birthRecord->father_age . ' Tahun' : '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Pekerjaan</td>
                    <td class="value">{{ $birthRecord->father_job ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td class="value">{{ $birthRecord->father_address ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="section note">
            Benar telah melahirkan seorang anak ke {{ $birthRecord->child_order ?? '-' }}
            dengan selamat di {{ $birthRecord->birth_place }}.
        </div>

        <div class="section">
            <div class="section-title">Rincian Kelahiran</div>
            <table class="detail-table">
                <tr>
                    <td class="label">Hari, Tanggal</td>
                    <td class="value">
                        {{ \Carbon\Carbon::parse($birthRecord->birth_date)->translatedFormat('l, d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Jam</td>
                    <td class="value">
                        {{ \Carbon\Carbon::parse($birthRecord->birth_time)->format('H:i') }} WIB
                    </td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td class="value">
                        {{ $birthRecord->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Berat Badan</td>
                    <td class="value">
                        {{ number_format($birthRecord->baby_weight, 0, ',', '.') }} Gram
                    </td>
                </tr>
                <tr>
                    <td class="label">Panjang Badan</td>
                    <td class="value">{{ $birthRecord->baby_length }} cm</td>
                </tr>
            </table>
        </div>

        <div class="section note">
            Anak tersebut diberi nama:
            <strong>{{ $birthRecord->baby_name }}</strong>
        </div>
    </div>

    <!-- Footer kiri -->
    <div class="footer-note">
        Demikian Surat Keterangan Lahir ini diberikan untuk dapat dipergunakan sebagaimana mestinya.
    </div>

    <!-- Tanda tangan kanan bawah -->
    <div class="signature">
        <div class="sign-box">
            <div class="sign-date">Natar, 16 April 2026</div>
            <div class="sign-title">{{ $birthRecord->attendant_name ?? 'Bidan Siti Hajar' }}</div>
            <div class="sign-name">bidan siti hajar</div>
        </div>
    </div>

</body>

</html>