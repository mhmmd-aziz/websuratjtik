@extends('layouts.admin')

@section('content')

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 bg-warning bg-opacity-10 position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Pending</p>
                            <h2 class="mb-0 fw-bold text-warning">{{ $stats['pending'] }}</h2>
                        </div>
                        <div class="bg-warning text-white rounded-3 p-3"><i class="bi bi-envelope-exclamation fs-4"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 bg-info bg-opacity-10 position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Diproses</p>
                            <h2 class="mb-0 fw-bold text-info">{{ $stats['diproses'] }}</h2>
                        </div>
                        <div class="bg-info text-white rounded-3 p-3"><i class="bi bi-arrow-repeat fs-4"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 bg-success bg-opacity-10 position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Selesai</p>
                            <h2 class="mb-0 fw-bold text-success">{{ $stats['selesai'] }}</h2>
                        </div>
                        <div class="bg-success text-white rounded-3 p-3"><i class="bi bi-check-circle-fill fs-4"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 bg-primary bg-opacity-10 position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Total</p>
                            <h2 class="mb-0 fw-bold text-primary">{{ $stats['total'] }}</h2>
                        </div>
                        <div class="bg-primary text-white rounded-3 p-3"><i class="bi bi-folder-fill fs-4"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white p-4 border-bottom-0 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <h5 class="fw-bold mb-3 mb-md-0"><i class="bi bi-inbox me-2 text-primary"></i>Daftar Surat Masuk</h5>
            
            <form action="{{ route('admin.jtik.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="cari" class="form-control bg-light border-0" placeholder="Cari surat..." value="{{ request('cari') }}">
                    <button class="btn btn-primary px-4" type="submit">Cari</button>
                    @if(request('cari'))
                        <a href="{{ route('admin.jtik.index') }}" class="btn btn-light ms-2"><i class="bi bi-x-lg"></i></a>
                    @endif
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3" width="20%">Pengirim</th>
                        <th width="25%">Perihal & File</th>
                        <th width="20%">Status Tracking</th>
                        <th class="pe-4" width="35%">Control Tower</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surat as $s)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 35px; height: 35px;">
                                    {{ substr($s->nama_pengirim, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $s->nama_pengirim }}</div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">{{ $s->email }}</div>
                                </div>
                            </div>
                            <div class="mt-2">
                                @if($s->sifat_surat == 'penting') <span class="badge bg-danger bg-opacity-10 text-danger px-2 border border-danger">🔥 Penting</span>
                                @elseif($s->sifat_surat == 'segera') <span class="badge bg-warning bg-opacity-10 text-warning px-2 border border-warning">⚡ Segera</span>
                                @else <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 border">Biasa</span> @endif
                            </div>
                        </td>

                        <td>
                            <div class="fw-bold text-dark">{{ $s->perihal_surat }}</div>
                            <small class="text-muted"><i class="bi bi-calendar me-1"></i> {{ $s->created_at->format('d M Y') }}</small>
                            @if($s->file_surat)
                                <div class="mt-1">
                                    <a href="{{ asset('storage/'.$s->file_surat) }}" target="_blank" class="btn btn-sm btn-outline-info py-0 px-2 rounded-pill" style="font-size: 0.75rem;">
                                        <i class="bi bi-paperclip"></i> Lihat File
                                    </a>
                                </div>
                            @endif
                        </td>

                        <td>
                            @if($s->disposisi->count() > 0)
                                <div class="d-flex flex-column gap-1">
                                    @foreach($s->disposisi as $d)
                                        <div class="d-flex align-items-center justify-content-between bg-white border px-2 py-1 rounded small">
                                            <span class="fw-bold text-dark">{{ $d->prodi->nama }}</span>
                                            @if($d->status == 'arsip') <span class="badge bg-success">Selesai</span>
                                            @elseif($d->status == 'disposisi') <span class="badge bg-warning text-dark">Proses</span>
                                            @else <span class="badge bg-secondary">Pending</span> @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="badge bg-light text-secondary border d-block py-2">Belum diteruskan</span>
                            @endif
                        </td>

                        <td class="pe-4">
                            <div class="card p-3 border-0 bg-light rounded-3">
                                
                                @if($s->disposisi->count() > 0)
                                    <div class="mb-2 pb-2 border-bottom">
                                        <small class="fw-bold text-muted d-block mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">TERKIRIM KE (KLIK X UNTUK CABUT):</small>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($s->disposisi as $d)
                                                <form action="{{ route('adminjtik.kiriman.batal', $d->id) }}" method="POST" onsubmit="return confirm('Cabut akses surat ini dari {{ $d->prodi->nama }}?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-white border shadow-sm btn-sm py-0 px-2 d-flex align-items-center text-dark" style="font-size: 0.75rem;">
                                                        <span class="fw-bold me-1">{{ $d->prodi->nama }}</span> <i class="bi bi-x-circle-fill text-danger"></i>
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
                                            <small class="fw-bold text-muted d-block mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">KIRIM KE:</small>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($prodi_belum as $p)
                                                    <div class="form-check form-check-inline m-0 p-0">
                                                        <input class="btn-check" type="checkbox" name="tujuan_prodi[]" value="{{ $p->id }}" id="p{{$p->id}}{{$s->id}}" autocomplete="off">
                                                        <label class="btn btn-outline-primary btn-sm rounded-pill py-0" style="font-size: 0.75rem;" for="p{{$p->id}}{{$s->id}}">{{ $p->nama }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <button type="submit" class="btn btn-primary btn-sm flex-grow-1 py-1 rounded-pill shadow-sm" style="font-size: 0.8rem;">
                                                <i class="bi bi-send-fill me-1"></i> Kirim
                                            </button>
                                            <button type="button" onclick="konfirmasiHapus('{{ $s->id }}')" class="btn btn-danger btn-sm py-1 px-3 rounded-pill shadow-sm" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="text-center">
                                        <div class="text-success fw-bold small mb-2"><i class="bi bi-check-all fs-5"></i> Terkirim ke Semua</div>
                                        <button type="button" onclick="konfirmasiHapus('{{ $s->id }}')" class="btn btn-outline-danger btn-sm rounded-pill w-100 py-1" style="font-size: 0.8rem;">
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
                    <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada surat masuk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Hapus Surat?',
            text: "Masuk ke tong sampah.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('form-hapus-' + id).submit();
        })
    }
</script>
@endpush