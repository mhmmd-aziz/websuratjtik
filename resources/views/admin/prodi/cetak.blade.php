<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Disposisi - {{ $surat->perihal_surat }}</title>
    <style>
        /* Desain Kertas A4 */
        body { 
            font-family: 'Times New Roman', Times, serif; 
            padding: 40px; 
            max-width: 800px; 
            margin: auto;
        }
        .header { 
            text-align: center; 
            border-bottom: 3px double black; 
            padding-bottom: 10px; 
            margin-bottom: 20px; 
        }
        .header h2 { font-size: 18px; margin: 2px 0; text-transform: uppercase; }
        .header h3 { font-size: 16px; margin: 2px 0; }
        .header p { font-size: 12px; margin: 0; font-style: italic; }
        
        .judul { 
            text-align: center; 
            font-weight: bold; 
            text-decoration: underline; 
            font-size: 16px; 
            margin-bottom: 20px; 
            text-transform: uppercase; 
        }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        td { padding: 10px; vertical-align: top; }
        
        .bg-gray { background-color: #f0f0f0; font-weight: bold; width: 180px; }
        .kotak-kosong { height: 120px; }
        
        .ttd { float: right; width: 250px; text-align: center; margin-top: 40px; }
        .ttd-nama { margin-top: 70px; font-weight: bold; text-decoration: underline; }

        /* Sembunyikan tombol saat diprint */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="position: fixed; bottom: 20px; right: 20px;">
        <button onclick="window.close()" style="background: red; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px;">
            Tutup Jendela
        </button>
    </div>

    <div class="header">
        <h2>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h2>
        <h2>POLITEKNIK NEGERI LHOKSEUMAWE</h2>
        <h3>JURUSAN TEKNOLOGI INFORMASI DAN KOMPUTER</h3>
        <h3>PROGRAM STUDI {{ $nama_prodi }}</h3>
        <p>Jalan Banda Aceh - Medan Km. 280.3 Buketrata, Lhokseumawe, 24301</p>
    </div>

    <div class="judul">LEMBAR DISPOSISI</div>

    <table>
        <tr>
            <td class="bg-gray">Surat Dari</td>
            <td>{{ $surat->nama_pengirim }} ({{ $surat->email }})</td>
        </tr>
        <tr>
            <td class="bg-gray">Tanggal Diterima</td>
            <td>{{ $surat->created_at->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="bg-gray">Nomor Agenda</td>
            <td>#{{ $surat->id }}/JTIK/{{ date('Y') }}</td>
        </tr>
        <tr>
            <td class="bg-gray">Perihal</td>
            <td><strong>{{ $surat->perihal_surat }}</strong></td>
        </tr>
        <tr>
            <td class="bg-gray">Status Surat</td>
            <td>{{ strtoupper($surat->status) }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="50%" style="vertical-align: top;">
                <strong>Catatan / Instruksi:</strong><br><br>
                
                @if($surat->catatan)
                    <div style="font-family: 'Courier New', Courier, monospace; font-size: 14px; line-height: 1.5;">
                        {{ $surat->catatan }}
                    </div>
                @else
                    <div class="kotak-kosong" style="color: #ccc;">
                        (Tidak ada catatan digital. Silakan isi manual)<br>
                        ......................................................................<br>
                        ......................................................................<br>
                        ......................................................................
                    </div>
                @endif
            </td>
        </tr>
    </table>

    <div class="ttd">
        <p>Lhokseumawe, {{ date('d F Y') }}<br>Koordinator Prodi {{ $nama_prodi }}</p>
        <p class="ttd-nama">( ..................................... )</p>
        <p>NIP. ...........................</p>
    </div>

</body>
</html>