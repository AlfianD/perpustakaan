<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak QR - {{ $buku->judul }}</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            padding: 50px;
        }

        .qr-card {
            border: 2px dashed #333;
            padding: 20px;
            display: inline-block;
            width: 300px;
        }

        .title {
            font-weight: bold;
            font-size: 16px;
            margin-top: 15px;
        }

        .author {
            font-size: 12px;
            color: #555;
        }

        @media print {
            body {
                padding: 0;
            }

            button {
                display: none;
            }

            /* Sembunyikan tombol saat diprint */
            .qr-card {
                border: 1px solid #000;
            }
        }
    </style>
</head>

<body>
    <button onclick="window.print()" style="margin-bottom: 20px; padding: 10px 20px; cursor:pointer;">Cetak QR
        Code</button>
    <br>
    <div class="qr-card">
        <div>{!! $qrCode !!}</div>
        <div class="title">{{ $buku->judul }}</div>
        <div class="author">{{ $buku->penulis }}</div>
        <div style="margin-top:10px; font-size: 10px; font-weight:bold;">SIPINTAR - Scan untuk Pinjam</div>
    </div>
</body>

</html>
