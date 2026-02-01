<!DOCTYPE html>
<html>

<head>
    <title>Surat Keterangan Kelahiran</title>
    <style>
        @page {
            margin: 0cm 0cm;
            size: A4 portrait;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 1.2cm 1.5cm;
            font-size: 11pt;
            color: #1a1a1a;
        }

        .certificate-border {
            border: 3px double #2c5f7d;
            padding: 0.8cm;
            position: relative;
        }

        .certificate-border::before {
            content: '';
            position: absolute;
            top: 0.3cm;
            left: 0.3cm;
            right: 0.3cm;
            bottom: 0.3cm;
            border: 1px solid #2c5f7d;
            pointer-events: none;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 3px solid #2c5f7d;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: linear-gradient(to right, transparent, #d4af37, transparent);
        }

        .logo-placeholder {
            width: 50px;
            height: 50px;
            margin: 0 auto 6px;
            background: linear-gradient(135deg, #2c5f7d 0%, #4a90b8 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .clinic-name {
            font-size: 18px;
            font-weight: bold;
            color: #2c5f7d;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }

        .clinic-info {
            font-size: 10px;
            color: #555;
            margin-bottom: 2px;
        }

        .document-title {
            text-align: center;
            margin: 10px 0 8px 0;
            background: linear-gradient(to right, #f8f9fa, #e9ecef, #f8f9fa);
            padding: 8px;
            border-left: 4px solid #d4af37;
            border-right: 4px solid #d4af37;
        }

        .document-title h3 {
            margin: 0;
            font-size: 15px;
            color: #2c5f7d;
            letter-spacing: 2px;
            font-weight: bold;
        }

        .document-number {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
        }

        .content {
            margin: 8px 10px;
            font-size: 10.5pt;
            line-height: 1.4;
        }

        .intro-text {
            text-align: justify;
            margin-bottom: 8px;
            font-style: italic;
            color: #333;
        }

        .section-box {
            background: #f8f9fa;
            border-left: 3px solid #2c5f7d;
            padding: 6px 10px;
            margin: 8px 0;
        }

        .section-title {
            font-weight: bold;
            font-size: 11pt;
            color: #2c5f7d;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-row {
            margin-bottom: 2px;
            display: flex;
            line-height: 1.3;
        }

        .data-label {
            width: 170px;
            font-weight: 600;
            color: #444;
            flex-shrink: 0;
        }

        .data-value {
            flex: 1;
            color: #1a1a1a;
        }

        .baby-name {
            font-weight: bold;
            color: #2c5f7d;
            font-size: 11pt;
        }

        .parent-section {
            background: white;
            border: 1px solid #dee2e6;
            padding: 6px 10px;
            margin: 6px 0;
            border-radius: 3px;
        }

        .parent-title {
            font-weight: bold;
            color: #2c5f7d;
            margin-bottom: 3px;
            font-size: 10pt;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 2px;
        }

        .medical-notes {
            margin-top: 8px;
            border: 1px solid #2c5f7d;
            background: #f0f7fb;
            padding: 5px 8px;
            font-size: 9.5pt;
            line-height: 1.3;
            border-radius: 3px;
        }

        .medical-notes strong {
            color: #2c5f7d;
        }

        .footer {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .footer-left {
            font-size: 9pt;
            color: #666;
            font-style: italic;
        }

        .footer-right {
            text-align: center;
            min-width: 200px;
        }

        .signature-box {
            border: 1px solid #dee2e6;
            padding: 8px 15px;
            background: white;
            border-radius: 3px;
        }

        .signature-title {
            font-size: 10pt;
            margin-bottom: 35px;
            color: #444;
        }

        .signature-name {
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 3px;
            font-size: 10pt;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(44, 95, 125, 0.03);
            font-weight: bold;
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>

<body>
    <div class="certificate-border">
        <div class="watermark">KLINIK</div>

        <div class="header">
            <div class="logo-placeholder">+</div>
            <div class="clinic-name">KLINIK SEHAT BERSAMA</div>
            <div class="clinic-info">Jl. Raya Kesehatan No. 123, Kota Sehat</div>
            <div class="clinic-info">Telp: (021) 12345678 | Email: info@kliniksehat.id</div>
        </div>

        <div class="document-title">
            <h3>SURAT KETERANGAN KELAHIRAN</h3>
            <div class="document-number">Nomor: {{ $birthRecord->birth_certificate_number ?? '...../SKL/..../20....' }}
            </div>
        </div>

        <div class="content">
            <p class="intro-text">Yang bertanda tangan di bawah ini, petugas kesehatan pada Klinik Sehat Bersama, dengan
                ini menerangkan bahwa:</p>

            <div class="section-box">
                <div class="section-title">Telah Lahir Seorang Bayi</div>
                <div class="data-row">
                    <span class="data-label">Hari, Tanggal</span>
                    <span class="data-value">:
                        {{ \Carbon\Carbon::parse($birthRecord->birth_date)->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Pukul</span>
                    <span class="data-value">: {{ \Carbon\Carbon::parse($birthRecord->birth_time)->format('H:i') }}
                        WIB</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Tempat Kelahiran</span>
                    <span class="data-value">: {{ $birthRecord->birth_place }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Jenis Kelamin</span>
                    <span class="data-value">: {{ $birthRecord->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Berat Badan</span>
                    <span class="data-value">: {{ number_format($birthRecord->baby_weight, 0, ',', '.') }} gram</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Panjang Badan</span>
                    <span class="data-value">: {{ $birthRecord->baby_length }} cm</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Nama Bayi</span>
                    <span class="data-value">: <span class="baby-name">{{ $birthRecord->baby_name }}</span></span>
                </div>
            </div>

            <div class="section-title" style="margin-top: 10px; margin-bottom: 5px;">Anak Dari Pasangan</div>

            <div style="display: flex; gap: 10px;">
                <div class="parent-section" style="flex: 1;">
                    <div class="parent-title">👤 IBU</div>
                    <div class="data-row">
                        <span class="data-label" style="width: 60px;">Nama</span>
                        <span class="data-value">: {{ $birthRecord->mother_name }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label" style="width: 60px;">NIK</span>
                        <span class="data-value">: {{ $birthRecord->mother_nik }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label" style="width: 60px;">Alamat</span>
                        <span class="data-value">: {{ $birthRecord->mother_address }}</span>
                    </div>
                </div>

                <div class="parent-section" style="flex: 1;">
                    <div class="parent-title">👤 AYAH</div>
                    <div class="data-row">
                        <span class="data-label" style="width: 60px;">Nama</span>
                        <span class="data-value">: {{ $birthRecord->father_name }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label" style="width: 60px;">NIK</span>
                        <span class="data-value">: {{ $birthRecord->father_nik }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label" style="width: 60px;">Alamat</span>
                        <span class="data-value">: {{ $birthRecord->father_address }}</span>
                    </div>
                </div>
            </div>

            @if($birthRecord->gpa || $birthRecord->head_circumference || $birthRecord->chest_circumference)
                <div class="medical-notes">
                    <strong>📋 Catatan Medis:</strong>
                    @if($birthRecord->gpa) GPA: {{ $birthRecord->gpa }} @endif
                    @if($birthRecord->head_circumference) | Lingkar Kepala: {{ $birthRecord->head_circumference }} cm @endif
                    @if($birthRecord->chest_circumference) | Lingkar Dada: {{ $birthRecord->chest_circumference }} cm @endif
                </div>
            @endif
        </div>

        <div class="footer">
            <div class="footer-left">
                Dokumen ini diterbitkan secara elektronis<br>
                dan sah tanpa tanda tangan basah
            </div>
            <div class="footer-right">
                <div class="signature-box">
                    <div style="font-size: 9pt; margin-bottom: 2px;">Kota Sehat,
                        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                    <div class="signature-title">Penolong Kelahiran</div>
                    <div class="signature-name">( _________________ )</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>