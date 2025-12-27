@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .card-modern { border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .table-modern thead th { background: #343a40; color: white; border: none; padding: 12px; }
    .table-modern tbody td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #eee; }
    .form-control-soft { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; }
    .form-control-soft:focus { background: white; box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1); border-color: #0d6efd; }
</style>

<div class="container mt-4 pb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="fw-bold mb-1">Dashboard Admin Prodi <span class="text-primary">{{ $nama_prodi }}</span></h3>
            <p class="text-muted m-0">Kelola surat masuk untuk program studi Anda.</p>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card card-modern p-2">
                <form action="{{ route('admin.prodi.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0 ps-3"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="cari" class="form-control border-0" 
                               placeholder="Cari Pengirim, Perihal, atau Kode Tiket..." 
                               value="{{ request('cari') }}">
                        <button class="btn btn-primary rounded-pill px-4" type="submit">Cari</button>
                        @if(request('cari'))
                            <a href="{{ route('admin.prodi.index') }}" class="btn btn-light rounded-pill ms-2" title="Reset"><i class="bi bi-x-lg"></i></a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger shadow-sm rounded-3 border-0">{{ session('error') }}</div>
    @endif

    <div class="card card-modern mb-5">
        <div class="card-header bg-white border-bottom p-4">
            <h5 class="fw-bold text-primary m-0"><i class="bi bi-inbox-fill me-2"></i> Surat Masuk (Perlu Tindakan)</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th width="20%">Pengirim</th>
                        <th width="25%">Perihal</th>
                        <th width="15%">File & Tgl</th>
                        <th width="40%">Aksi & Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surat_baru as $item)
                        @if($item->surat)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->surat->nama_pengirim ?? '-' }}</div>
                            </td>
                            <td>{{ $item->surat->perihal_surat ?? '-' }}</td>
                            <td>
                                <div class="d-flex flex-column gap-2">
                                    <span class="text-muted small"><i class="bi bi-calendar"></i> {{ $item->updated_at->format('d/m/Y') }}</span>
                                    @if($item->surat->file_surat)
                                        <a href="{{ asset('storage/'.$item->surat->file_surat) }}" target="_blank" class="btn btn-sm btn-info text-white rounded-pill px-3">
                                            <i class="bi bi-file-pdf"></i> Lihat PDF
                                        </a>
                                    @else <span class="text-muted small">-</span> @endif
                                </div>
                            </td>
                            <td>
                                <div class="bg-light p-3 rounded-3 border">
                                    <form id="form-surat-{{ $item->id }}" action="{{ route('prodi.surat.update', $item->id) }}" method="POST">
                                        @csrf
                                        <label class="small text-muted fw-bold mb-1">Instruksi / Catatan:</label>
                                        <textarea name="catatan" class="form-control form-control-soft form-control-sm mb-2" rows="2" placeholder="Tulis instruksi tindak lanjut..."></textarea>
                                        
                                        <div class="d-flex gap-2">
                                            <button type="submit" name="aksi" value="disposisi" class="btn btn-warning btn-sm flex-grow-1 rounded-pill fw-bold text-dark">
                                                ⚠️ Disposisi
                                            </button>
                                            <button type="button" onclick="konfirmasiArsip('{{ $item->id }}')" class="btn btn-success btn-sm flex-grow-1 rounded-pill fw-bold">
                                                ✅ Arsip (Selesai)
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="bi bi-check-circle-fill text-success fs-1 mb-3"></i>
                            <h6 class="text-muted">Tidak ada surat pending. Pekerjaan Anda selesai!</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-modern bg-white">
        <div class="card-header bg-light border-bottom p-4">
            <h5 class="fw-bold text-secondary m-0"><i class="bi bi-clock-history me-2"></i> Riwayat Surat (Sudah Diproses)</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Status Akhir</th>
                        <th>Catatan Anda</th>
                        <th width="15%">Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surat_selesai as $item)
                        @if($item->surat)
                        <tr>
                            <td>{{ $item->surat->nama_pengirim ?? '-' }}</td>
                            <td>{{ $item->surat->perihal_surat ?? '-' }}</td>
                            <td class="text-center">
                                @if($item->status == 'arsip')
                                    <span class="badge bg-success rounded-pill px-3">✅ ARSIP (SELESAI)</span>
                                @else
                                    <div class="d-flex flex-column align-items-center gap-2">
                                        <span class="badge bg-warning text-dark rounded-pill px-3">⚠️ SEDANG PROSES</span>
                                        <form action="{{ route('prodi.surat.update', $item->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="aksi" value="arsip">
                                            <input type="hidden" name="catatan" value="{{ $item->catatan }}">
                                            <button type="submit" class="btn btn-outline-success btn-sm rounded-pill" style="font-size: 0.75rem;">
                                                <i class="bi bi-check-circle-fill me-1"></i> Tandai Selesai
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($item->catatan)
                                    <div class="bg-light p-2 rounded small text-muted fst-italic border">"{{ $item->catatan }}"</div>
                                @else - @endif
                            </td>
                            <td>
                                <a href="{{ route('prodi.surat.cetak', $item->id) }}" target="_blank" class="btn btn-dark btn-sm w-100 rounded-pill">
                                    <i class="bi bi-printer me-1"></i> Cetak
                                </a>
                            </td>
                        </tr>
                        @endif
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada riwayat surat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{!! session('success') !!}",
            showConfirmButton: false,
            timer: 2000,
            confirmButtonColor: '#0d6efd'
        });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}" });
    @endif

    function konfirmasiArsip(id) {
        Swal.fire({
            title: 'Yakin mau Arsip?',
            text: "Surat akan ditandai selesai dan dipindahkan ke riwayat.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Arsipkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.getElementById('form-surat-' + id);
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'aksi';
                input.value = 'arsip';
                form.appendChild(input);
                form.submit();
            }
        })
    }
</script>

@endsection