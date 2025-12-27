<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin JTIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            background-color: #f3f4f6; 
            font-family: 'Inter', sans-serif; 
            color: #374151;
        }
        
        /* Card Statistik Modern */
        .stat-card {
            border: none;
            border-radius: 16px;
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .stat-icon-bg {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 5rem;
            opacity: 0.15;
            transform: rotate(-15deg);
        }

        /* Tabel Modern */
        .table-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .table thead th {
            background-color: #f9fafb;
            color: #6b7280;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            padding: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #1f2937;
            font-size: 0.875rem;
        }
        .table-hover tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Badges & Buttons */
        .badge-soft-warning { background-color: #fef3c7; color: #d97706; }
        .badge-soft-success { background-color: #d1fae5; color: #059669; }
        .badge-soft-danger { background-color: #fee2e2; color: #dc2626; }
        .badge-soft-info { background-color: #dbeafe; color: #2563eb; }
        .badge-soft-secondary { background-color: #f3f4f6; color: #4b5563; }
        
        .btn-action {
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-action:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container py-4">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
        <div class="mb-3 mb-md-0">
            <h2 class="fw-bold text-dark m-0">Dashboard Admin JTIK</h2>
            <p class="text-muted m-0">Sistem Manajemen & Monitoring Surat Masuk</p>
        </div>
        
        <div class="d-flex gap-2">
            <a href="{{ route('adminjtik.export') }}" class="btn btn-success fw-bold px-4 rounded-pill shadow-sm">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export Excel
            </a>

            <a href="{{ route('adminjtik.sampah.index') }}" class="btn btn-warning text-dark fw-bold px-4 rounded-pill shadow-sm">
                <i class="bi bi-trash me-1"></i> Tong Sampah
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger fw-bold px-4 rounded-pill shadow-sm">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-12 col-md-3">
            <div class="card stat-card bg-warning text-white h-100 p-3">
                <div class="d-flex justify-content-between align-items-center position-relative z-1">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75 fw-bold">Surat Pending</h6>
                        <h2 class="mb-0 fw-bold display-5">{{ $stats['pending'] }}</h2>
                    </div>
                    <i class="bi bi-envelope-exclamation stat-icon-bg"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card stat-card bg-info text-white h-100 p-3">
                <div class="d-flex justify-content-between align-items-center position-relative z-1">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75 fw-bold">Sedang Proses</h6>
                        <h2 class="mb-0 fw-bold display-5">{{ $stats['diproses'] }}</h2>
                    </div>
                    <i class="bi bi-arrow-repeat stat-icon-bg"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card stat-card bg-success text-white h-100 p-3">
                <div class="d-flex justify-content-between align-items-center position-relative z-1">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75 fw-bold">Selesai/Arsip</h6>
                        <h2 class="mb-0 fw-bold display-5">{{ $stats['selesai'] }}</h2>
                    </div>
                    <i class="bi bi-check-circle-fill stat-icon-bg"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card stat-card bg-primary text-white h-100 p-3">
                <div class="d-flex justify-content-between align-items-center position-relative z-1">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75 fw-bold">Total Surat</h6>
                        <h2 class="mb-0 fw-bold display-5">{{ $stats['total'] }}</h2>
                    </div>
                    <i class="bi bi-folder-fill stat-icon-bg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card table-card bg-white">
        <div class="card-header bg-white border-bottom p-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <h5 class="fw-bold m-0 d-flex align-items-center">
                <i class="bi bi-inbox text-primary me-2 fs-4"></i> Daftar Surat Masuk
            </h5>
            <form action="{{ route('admin.jtik.index') }}" method="GET" class="mt-3 mt-md-0 position-relative">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="cari" class="form-control bg-light border-start-0 rounded-end-pill" 
                           placeholder="Cari surat..." value="{{ request('cari') }}" style="min-width: 250px;">
                    @if(request('cari'))
                        <a href="{{ route('admin.jtik.index') }}" class="btn btn-link text-decoration-none position-absolute end-0 top-0 mt-1 me-5 z-3">
                            <i class="bi bi-x-circle-fill text-secondary"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="20%">Pengirim & Info</th>
                        <th width="25%">Perihal & File</th>
                        <th width="20%">Status Tracking</th>
                        <th width="35%">Control Tower (Aksi)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surat as $s)
                    <tr>
                        <td>
                            <div class="d-flex align-items-start">
                                <div class="avatar me-2 mt-1">
                                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center fw-bold" style="width: 35px; height: 35px;">
                                        {{ substr($s->nama_pengirim, 0, 1) }}
                                    </div>
                                </div>
                                <div>
                                    <span class="fw-bold d-block text-dark">{{ $s->nama_pengirim }}</span>
                                    <small class="text-muted d-block mb-1">{{ $s->email }}</small>
                                    @if($s->sifat_surat == 'penting') 
                                        <span class="badge badge-soft-danger rounded-pill px-2">🔥 Penting</span>
                                    @elseif($s->sifat_surat == 'segera') 
                                        <span class="badge badge-soft-warning rounded-pill px-2">⚡ Segera</span>
                                    @else 
                                        <span class="badge badge-soft-secondary rounded-pill px-2">Biasa</span> 
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <p class="fw-semibold text-dark mb-1" style="line-height: 1.4;">{{ $s->perihal_surat }}</p>
                            <small class="text-muted d-block">
                                <i class="bi bi-calendar-event me-1"></i> {{ $s->created_at->format('d M Y') }}
                            </small>
                            @if($s->file_surat)
                                <a href="{{ asset('storage/'.$s->file_surat) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-2" style="font-size: 0.75rem;">
                                    <i class="bi bi-file-earmark-pdf me-1"></i> Lihat PDF
                                </a>
                            @endif
                        </td>

                        <td>
                            @if($s->disposisi->count() > 0)
                                <div class="d-flex flex-column gap-2">
                                    @foreach($s->disposisi as $d)
                                        <div class="d-flex justify-content-between align-items-center p-2 rounded border bg-light">
                                            <span class="fw-bold text-dark small">{{ $d->prodi->nama }}</span>
                                            @if($d->status == 'arsip')
                                                <span class="badge bg-success rounded-pill" style="font-size: 0.65rem;">✅ Selesai</span>
                                            @elseif($d->status == 'disposisi')
                                                <span class="badge bg-warning text-dark rounded-pill" style="font-size: 0.65rem;">⚠️ Disposisi</span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill" style="font-size: 0.65rem;">⏳ Pending</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="badge badge-soft-secondary d-block py-2">Belum diteruskan</span>
                            @endif
                        </td>
                        
                        <td>
                            <div class="p-3 bg-light rounded-3 border">
                                
                                @if($s->disposisi->count() > 0)
                                    <div class="mb-2 pb-2 border-bottom">
                                        <small class="fw-bold text-muted d-block mb-1" style="font-size: 0.7rem;">TERKIRIM KE (KLIX X UNTUK CABUT):</small>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($s->disposisi as $d)
                                                <form action="{{ route('adminjtik.kiriman.batal', $d->id) }}" method="POST" onsubmit="return confirm('Batalkan kiriman ke {{ $d->prodi->nama }}?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2 rounded-pill d-flex align-items-center gap-1 bg-white" style="font-size: 0.7rem;">
                                                        {{ $d->prodi->nama }} <i class="bi bi-x-circle-fill"></i>
                                                    </button>
                                                </form>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @php
                                    $sudah_dikirim = $s->disposisi->pluck('prodi_id')->toArray();
                                    $prodi_belum = $prodi->whereNotIn('id', $sudah_dikirim);
                                @endphp

                                @if($prodi_belum->count() > 0)
                                    <form action="{{ route('adminjtik.surat.kirim', $s->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-2">
                                            <small class="fw-bold text-muted d-block mb-1" style="font-size: 0.7rem;">KIRIM KE:</small>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($prodi_belum as $p)
                                                    <div class="form-check form-check-inline m-0">
                                                        <input class="btn-check" type="checkbox" name="tujuan_prodi[]" value="{{ $p->id }}" id="p{{$p->id}}{{$s->id}}" autocomplete="off">
                                                        <label class="btn btn-outline-primary btn-sm rounded-pill" style="font-size: 0.7rem;" for="p{{$p->id}}{{$s->id}}">{{ $p->nama }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary btn-sm flex-grow-1 rounded-pill shadow-sm">
                                                <i class="bi bi-send-fill me-1"></i> Kirim Surat
                                            </button>
                                            
                                            <button type="button" onclick="konfirmasiHapus('{{ $s->id }}')" class="btn btn-danger btn-sm px-3 rounded-pill shadow-sm" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="text-center py-2">
                                        <div class="text-success fw-bold small mb-2"><i class="bi bi-check-all fs-5"></i> Terkirim ke Semua</div>
                                        <button type="button" onclick="konfirmasiHapus('{{ $s->id }}')" class="btn btn-outline-danger btn-sm rounded-pill w-100">
                                            <i class="bi bi-trash me-1"></i> Hapus Surat
                                        </button>
                                    </div>
                                @endif

                                <form id="form-hapus-{{ $s->id }}" action="{{ route('adminjtik.surat.hapus', $s->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="opacity-50">
                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                <h6 class="fw-bold">Tidak ada surat masuk</h6>
                                <p class="small text-muted">Belum ada data surat baru saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{!! session('success') !!}", showConfirmButton: false, timer: 2000, confirmButtonColor: '#0d6efd' });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}" });
    @endif

    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Hapus Surat Ini?',
            text: "Data akan dipindahkan ke Tong Sampah.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-' + id).submit();
            }
        })
    }
</script>
</body>
</html>