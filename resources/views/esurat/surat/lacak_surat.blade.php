<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Status Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset("foto/tik.jpg") }}') center/cover fixed;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: white;
        }
        .card-track {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            color: #333;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        /* Timeline CSS */
        .timeline-steps {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .timeline-step {
            align-items: center;
            display: flex;
            flex-direction: column;
            position: relative;
            margin: 0 15px;
        }
        .timeline-content {
            width: 100px;
            text-align: center;
        }
        .timeline-step .inner-circle {
            border-radius: 50%;
            height: 50px;
            width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e9ecef;
            border: 3px solid #dee2e6;
            z-index: 10;
            font-size: 20px;
            color: #6c757d;
            transition: 0.3s;
        }
        /* Garis penghubung */
        .timeline-step:not(:last-child):after {
            content: "";
            position: absolute;
            height: 3px;
            width: 100%;
            top: 25px;
            left: 50%;
            background-color: #dee2e6;
            z-index: 0;
        }
        /* Warna Aktif */
        .timeline-step.active .inner-circle {
            background-color: #bf00ff;
            border-color: #bf00ff;
            color: white;
            box-shadow: 0 0 15px rgba(191, 0, 255, 0.4);
        }
        .timeline-step.active:after {
            background-color: #bf00ff;
        }
        .timeline-step.completed .inner-circle {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        .timeline-step.completed:after {
            background-color: #28a745;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent pt-4">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="/">
                <i class="bi bi-envelope-paper-fill" style="color: #bf00ff;"></i> JTIK E-Surat
            </a>
            <a href="/" class="btn btn-outline-light rounded-pill px-4">Kembali ke Home</a>
        </div>
    </nav>

    <div class="container d-flex flex-column align-items-center justify-content-center flex-grow-1 mt-5 mb-5">
        
        <div class="card card-track p-5 w-100" style="max-width: 800px;">
            <h2 class="text-center fw-bold mb-4">Lacak Status Surat</h2>
            
            <form method="POST" action="{{ route('surat.track') }}" class="mb-5">
                @csrf
                <div class="input-group input-group-lg">
                    <input type="text" name="kode_tiket" class="form-control" 
                           placeholder="Masukkan Kode Unik (Contoh: X8Y29A)" 
                           required value="{{ $surat_data->kode_tiket ?? '' }}" 
                           style="text-transform: uppercase;"> 

                    <button class="btn btn-primary" style="background-color: #bf00ff; border:none;" type="submit">Lacak</button>
                </div>
            </form>

            @if(session('status_message'))
                <div class="alert alert-danger text-center">
                    {!! session('status_message')['text'] !!}
                </div>
            @endif

            @if($surat_data)
                
                <div class="bg-light p-3 rounded mb-4 border">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Pengirim:</small>
                            <h5 class="fw-bold">{{ $surat_data->nama_pengirim }}</h5>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <small class="text-muted">Perihal:</small>
                            <h5 class="fw-bold">{{ $surat_data->perihal_surat }}</h5>
                        </div>
                    </div>
                </div>

                @php
                    $status = $surat_data->status;
                    $step1 = 'completed'; 
                    $step2 = ($status == 'terkirim' || $status == 'disposisi' || $status == 'arsip') ? 'completed' : '';
                    $step3 = ($status == 'disposisi' || $status == 'arsip') ? 'completed' : '';
                    $step4 = ($status == 'arsip') ? 'completed' : '';
                    
                    if($status == 'pending') $step1 = 'active';
                    if($status == 'terkirim') $step2 = 'active';
                    if($status == 'disposisi') $step3 = 'active';
                    if($status == 'arsip') $step4 = 'active';
                @endphp

                <div class="timeline-steps">
                    <div class="timeline-step {{ $step1 }}">
                        <div class="inner-circle"><i class="bi bi-send"></i></div>
                        <p class="mt-2 fw-bold small text-muted">Terkirim</p>
                    </div>
                    <div class="timeline-step {{ $step2 }}">
                        <div class="inner-circle"><i class="bi bi-building-check"></i></div>
                        <p class="mt-2 fw-bold small text-muted">Admin JTIK</p>
                    </div>
                    <div class="timeline-step {{ $step3 }}">
                        <div class="inner-circle"><i class="bi bi-people"></i></div>
                        <p class="mt-2 fw-bold small text-muted">Diterima Prodi</p>
                    </div>
                    <div class="timeline-step {{ $step4 }}">
                        <div class="inner-circle"><i class="bi bi-archive-fill"></i></div>
                        <p class="mt-2 fw-bold small text-muted">Selesai/Arsip</p>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <span class="badge bg-dark fs-6 px-4 py-2">Status Saat Ini: {{ strtoupper($status) }}</span>
                </div>

                <div class="mt-4 p-4 bg-white rounded border shadow-sm text-start">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">📋 Detail Penelusuran</h5>
                    <div class="row">
                        <div class="col-12 mb-3 text-center">
                            <small class="text-muted">KODE TIKET:</small>
                            <h1 class="fw-bold text-primary" style="letter-spacing: 5px;">
                                {{ $surat_data->kode_tiket }}
                            </h1>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Status Terkini (Global):</label>
                            <div>
                                @if($surat_data->status == 'arsip')
                                    <span class="badge bg-success fs-6">✅ Selesai / Diarsipkan</span>
                                @elseif($surat_data->status == 'disposisi')
                                    <span class="badge bg-warning text-dark fs-6">⚠️ Disposisi (Tindak Lanjut)</span>
                                @elseif($surat_data->status == 'terkirim')
                                    <span class="badge bg-primary fs-6">✈️ Sedang di Prodi</span>
                                @else
                                    <span class="badge bg-secondary fs-6">⏳ Pending (Di Admin JTIK)</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small fw-bold text-uppercase mb-2">Posisi & Status Per Unit:</label>
                            <div class="card bg-light border-0">
                                <ul class="list-group list-group-flush bg-transparent">
                                    @if($surat_data->disposisi->count() > 0)
                                        @foreach($surat_data->disposisi as $d)
                                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-3 py-2">
                                                <span class="fw-bold text-dark">
                                                    <i class="bi bi-building me-1 text-secondary"></i> 
                                                    Prodi {{ $d->prodi->nama ?? '-' }}
                                                </span>
                                                
                                                @if($d->status == 'arsip')
                                                    <span class="badge bg-success rounded-pill">
                                                        <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                                    </span>
                                                @elseif($d->status == 'disposisi')
                                                    <span class="badge bg-warning text-dark rounded-pill">
                                                        <i class="bi bi-exclamation-circle-fill me-1"></i> Disposisi
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary rounded-pill">
                                                        <i class="bi bi-hourglass-split me-1"></i> Pending
                                                    </span>
                                                @endif
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="list-group-item bg-transparent text-center text-muted py-3">
                                            <small>Surat masih di Admin JTIK (Belum diteruskan)</small>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Terakhir Diupdate:</label>
                            <p class="fw-bold font-monospace">
                                <i class="bi bi-clock-history"></i> {{ $surat_data->updated_at->format('d F Y, H:i') }} WIB
                            </p>
                        </div>
                    </div>
                </div>

            @endif 
        </div>
    </div>

</body>
</html>