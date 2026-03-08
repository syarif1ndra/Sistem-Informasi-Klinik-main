<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Verifikasi Email - Klinik Bidan Siti Hajar</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #fce7f3;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #fce7f3;
            padding-bottom: 40px;
        }

        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            color: #4b5563;
            border-radius: 12px;
            overflow: hidden;
            margin-top: 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #ec4899 0%, #be123c 100%);
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }

        .content h2 {
            color: #111827;
            font-size: 20px;
            margin-top: 0;
        }

        .button-wrapper {
            text-align: center;
            margin: 35px 0;
        }

        .button {
            background-color: #db2777;
            color: #ffffff !important;
            padding: 14px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            display: inline-block;
            transition: background-color 0.2s;
        }

        .footer {
            padding: 20px;
            text-align: center;
            color: #9ca3af;
            font-size: 13px;
        }

        .footer p {
            margin: 5px 0;
        }

        .divider {
            height: 1px;
            background-color: #f3f4f6;
            margin: 30px 0;
        }

        .note {
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <table class="main">
            <tr>
                <td class="header">
                    <h1>🏥 Klinik Bidan Siti Hajar</h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h2>Halo, {{ $name }}!</h2>
                    <p>Terima kasih telah mendaftar di <strong>Klinik Bidan Siti Hajar</strong>. Kami sangat senang Anda
                        bergabung dengan kami.</p>
                    <p>Satu langkah lagi untuk mengaktifkan akun Anda. Silakan klik tombol di bawah ini untuk
                        memverifikasi alamat email Anda:</p>

                    <div class="button-wrapper">
                        <a href="{{ $url }}" class="button">Verifikasi Email Saya</a>
                    </div>

                    <p>Jika Anda tidak merasa mendaftar di layanan kami, Anda dapat mengabaikan email ini dengan aman.
                    </p>

                    <p>Salam hangat,<br><strong>Tim Klinik Bidan Siti Hajar</strong></p>
                </td>
            </tr>
        </table>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Klinik Bidan Siti Hajar. Semua hak dilindungi.</p>
            <p>Jl. Contoh No. 123, Kota Anda, Indonesia</p>
        </div>
    </div>
</body>

</html>