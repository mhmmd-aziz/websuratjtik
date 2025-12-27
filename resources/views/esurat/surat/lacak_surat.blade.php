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
            background: rgba(255, 255, 255, 0.98);
            border-radius: 15px;
            color: #333;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        }
        
        /* Timeline CSS */
        .timeline-steps {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .timeline-step {
            align-items: center;
            display: flex;
            flex-direction: column;
            position: relative;
            margin: 0 10px;
            width: 100px;
        }
        .timeline-step .inner-circle {
            border-radius: 50%;
            height: 55px;
            width: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border: 4px solid #e9ecef;
            z-index: 10;
            font-size: 22px;
            color: #adb5bd;
            transition: 0.4s ease;
        }
        /* Garis penghubung */
        .timeline-step:not(:last-child):after {
            content: "";
            position: absolute;
            height: 4px;
            width: 100%;
            top: 26px;
            left: 50%;
            background-color: #e9ecef;
            z-index: 0;
            transition: 0.4s ease;
        }
        
        /* STATE: ACTIVE (Sedang diproses disini) */
        .timeline-step.active .inner-circle {
            background-color: white;
            border-color: #bf00ff;
            color: #bf00ff;
            box-shadow: 0 0 0 5px rgba(191, 0, 255, 0.2);
            transform: scale(1.1);
        }
        .timeline-step.active p {
            color: #bf00ff !important;
            font-weight: 800 !important;
        }

        /* STATE: COMPLETED (Sudah lewat) */
        .timeline-step.completed .inner-circle {
            background-color: #198754;
            border-color: #198754;
            color: white;
        }
        .timeline-step.completed:after {
            background-color: #198754;
        }
        .timeline-step.completed p {
            color: #198754 !important;
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
        
        <div class="card card-track p-4 p-md-5 w-100" style="max-width: 850px;">
            <h3 class="text-center fw-bold mb-4">Lacak Status Surat</h3>
            
            <form method="POST" action="{{ route('surat.track') }}" class="mb-5">
                @csrf
                <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden">
                    <input type="text" name="kode_tiket" class="form-control border-0 ps-4" 
                           placeholder="Masukkan Kode Tiket (Contoh: X8Y29A)" 
                           required value="{{ $surat_data->kode_tiket ?? '' }}" 
                           style="text-transform: uppercase; font-weight: 600; letter-spacing: 1px;"> 

                    <button class="btn btn-primary px-4 fw-bold" style="background-color: #bf00ff; border:none;" type="submit">
                        <i class="bi bi-search me-1"></i> LACAK
                    </button>
                </div>
            </form>

            @if(session('status_message'))
                <div class="alert alert-danger text-center rounded-4 border-0 shadow-sm">
                    {!! session('status_message')['text'] !!}
                </div>
            @endif

            @if($surat_data)
                
                @php
                    $list_disposisi = $surat_data->disposisi;
                    $total_unit     = $list_disposisi->count();
                    $total_selesai  = $list_disposisi->where('status', 'arsip')->count();
                    
                    // Default Status Visual
                    $visual_step = 1; // 1=Dikirim, 2=Admin JTIK, 3=Prodi, 4=Selesai
                    $text_status = "Pending";
                    $class_badge = "bg-secondary";

                    if($surat_data->status == 'pending'){
                        $visual_step = 2; // Sedang di Admin JTIK
                        $text_status = "Menunggu Tindakan Admin JTIK";
                        $class_badge = "bg-secondary";
                    } 
                    elseif($surat_data->status == 'terkirim' || $surat_data->status == 'disposisi'){
                        if($total_unit > 0 && $total_unit == $total_selesai){
                            // JIKA SEMUA UNIT SUDAH ARSIP -> MAKA GLOBAL SELESAI
                            $visual_step = 4; 
                            $text_status = "SELESAI (Semua Unit Telah Mengarsipkan)";
                            $class_badge = "bg-success";
                        } else {
                            // JIKA MASIH ADA YG BELUM
                            $visual_step = 3;
                            $text_status = "Sedang Diproses di Unit/Prodi";
                            $class_badge = "bg-primary";
                        }
                    } 
                    elseif($surat_data->status == 'arsip'){
                        // Kalau Admin JTIK manual arsip
                        $visual_step = 4;
                        $text_status = "Diarsipkan oleh JTIK";
                        $class_badge = "bg-success";
                    }
                @endphp

                <div class="timeline-steps">
                    <div class="timeline-step completed">
                        <div class="inner-circle"><i class="bi bi-send-check"></i></div>
                        <p class="mt-2 fw-bold small text-muted text-center">Terkirim</p>
                    </div>

                    <div class="timeline-step {{ $visual_step >= 2 ? 'completed' : ($visual_step == 1 ? 'active' : '') }}">
                        <div class="inner-circle"><i class="bi bi-person-gear"></i></div>
                        <p class="mt-2 fw-bold small text-muted text-center">Admin JTIK</p>
                    </div>

                    <div class="timeline-step {{ $visual_step >= 3 ? 'completed' : ($visual_step == 2 ? 'active' : '') }}">
                        <div class="inner-circle"><i class="bi bi-diagram-3"></i></div>
                        <p class="mt-2 fw-bold small text-muted text-center">Admin Prodi</p>
                    </div>

                    <div class="timeline-step {{ $visual_step == 4 ? 'completed' : '' }}">
                        <div class="inner-circle"><i class="bi bi-check-circle-fill"></i></div>
                        <p class="mt-2 fw-bold small text-muted text-center">Selesai</p>
                    </div>
                </div>

                <div class="text-center mt-2 mb-4">
                    <span class="badge {{ $class_badge }} fs-6 px-4 py-2 rounded-pill shadow-sm">
                        {{ strtoupper($text_status) }}
                    </span>
                </div>

                <div class="bg-white p-4 rounded-4 border shadow-sm">
                    <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-card-heading me-2"></i>Detail Surat</h5>
                    
                    <div class="row g-4">
                        <div class="col-md-6 border-end">
                            <div class="mb-3">
                                <label class="text-muted small fw-bold">PENGIRIM</label>
                                <div class="fs-5 fw-bold text-dark">{{ $surat_data->nama_pengirim }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small fw-bold">PERIHAL</label>
                                <div class="fs-6 text-dark">{{ $surat_data->perihal_surat }}</div>
                            </div>
                            <div>
                                <label class="text-muted small fw-bold">KODE TIKET</label>
                                <div class="fs-4 fw-bold text-primary font-monospace">{{ $surat_data->kode_tiket }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 ps-md-4">
                            <label class="text-muted small fw-bold mb-2">STATUS PER UNIT TUJUAN:</label>
                            
                            @if($list_disposisi->count() > 0)
                                <div class="d-flex flex-column gap-2">
                                    @foreach($list_disposisi as $d)
                                        <div class="d-flex justify-content-between align-items-center p-2 rounded border bg-light">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-white p-2 rounded-circle shadow-sm me-2">
                                                    <i class="bi bi-building text-secondary"></i>
                                                </div>
                                                <span class="fw-bold text-dark">Prodi {{ $d->prodi->nama }}</span>
                                            </div>

                                            @if($d->status == 'arsip')
                                                <span class="badge bg-success rounded-pill px-3">
                                                    <i class="bi bi-check-all me-1"></i> Selesai
                                                </span>
                                            @elseif($d->status == 'disposisi')
                                                <span class="badge bg-warning text-dark rounded-pill px-3">
                                                    <i class="bi bi-gear-wide-connected me-1"></i> Diproses
                                                </span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill px-3">
                                                    <i class="bi bi-clock me-1"></i> Pending
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-secondary d-flex align-items-center" role="alert">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <div>Surat belum diteruskan ke prodi manapun.</div>
                                </div>
                            @endif

                            <div class="mt-4 pt-3 border-top">
                                <label class="text-muted small fw-bold">UPDATE TERAKHIR</label>
                                <div class="fw-bold text-secondary">
                                    <i class="bi bi-calendar-check me-1"></i> 
                                    {{ $surat_data->updated_at->format('d F Y, H:i') }} WIB
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif 
        </div>
    </div>

</body>
</html>