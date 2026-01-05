@extends('layouts.admin')

@section('content')

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.prodi.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="cari" class="form-control border-0" placeholder="Cari Pengirim, Perihal, atau Kode Tiket..." value="{{ request('cari') }}">
                    <button class="btn btn-primary px-4 rounded-3" type="submit">Cari</button>
                    @if(request('cari')) <a href="{{ route('admin.prodi.index') }}" class="btn btn-light ms-2"><i class="bi bi-x-lg"></i></a> @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white p-4 border-bottom-0">
            <h5 class="fw-bold m-0 text-primary"><i class="bi bi-inbox-fill me-2"></i> Surat Masuk (Perlu Tindakan)</h5>
        </div>
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Pengirim</th>
                        <th>Perihal</th>
                        <th>Info File</th>
                        <th class="pe-4" width="35%">Aksi & Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surat_baru as $item)
                        @if($item->surat)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $item->surat->nama_pengirim ?? '-' }}</div>
                                <div class="small text-muted">{{ $item->surat->email ?? '' }}</div>
                            </td>
                            <td>{{ $item->surat->perihal_surat ?? '-' }}</td>
                            <td>
                                <div class="small text-muted mb-1">{{ $item->updated_at->format('d/m/Y') }}</div>
                                @if($item->surat->file_surat)
                                    <a href="{{ asset('storage/'.$item->surat->file_surat) }}" target="_blank" class="btn btn-sm btn-info text-white rounded-pill px-3 py-0" style="font-size: 11px;">
                                        <i class="bi bi-file-earmark-pdf"></i> PDF
                                    </a>
                                @endif
                            </td>
                            <td class="pe-4">
                                <div class="bg-light p-3 rounded-3 border">
                                    <form id="form-surat-{{ $item->id }}" action="{{ route('prodi.surat.update', $item->id) }}" method="POST">
                                        @csrf
                                        <textarea name="catatan" class="form-control form-control-sm mb-2" rows="2" placeholder="Tulis instruksi/catatan..."></textarea>
                                        <div class="d-flex gap-2">
                                            <button type="submit" name="aksi" value="disposisi" class="btn btn-warning btn-sm flex-grow-1 fw-bold text-dark rounded-pill">
                                                ⚠️ Disposisi
                                            </button>
                                            <button type="button" onclick="konfirmasiArsip('{{ $item->id }}')" class="btn btn-success btn-sm flex-grow-1 fw-bold rounded-pill">
                                                ✅ Arsip
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
                            <i class="bi bi-check2-circle fs-1 text-success d-block mb-2"></i>
                            <span class="text-muted">Tidak ada surat pending.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white p-4 border-bottom-0">
            <h5 class="fw-bold m-0 text-secondary"><i class="bi bi-clock-history me-2"></i> Riwayat Surat</h5>
        </div>
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Pengirim</th>
                        <th>Perihal</th>
                        <th>Status Saat Ini</th>
                        <th>Catatan</th>
                        <th class="pe-4 text-end">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surat_selesai as $item)
                        @if($item->surat)
                        <tr>
                            <td class="ps-4">{{ $item->surat->nama_pengirim ?? '-' }}</td>
                            <td>{{ $item->surat->perihal_surat ?? '-' }}</td>
                            <td>
                                @if($item->status == 'arsip')
                                    <span class="badge bg-success rounded-pill px-3">✅ ARSIP (SELESAI)</span>
                                @else
                                    <form action="{{ route('prodi.surat.update', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="aksi" value="arsip">
                                        <input type="hidden" name="catatan" value="{{ $item->catatan }}">
                                        
                                        <button type="submit" class="btn badge bg-warning text-dark border-0 rounded-pill px-3" title="Klik untuk tandai selesai">
                                            ⚠️ SEDANG PROSES <i class="bi bi-arrow-right ms-1"></i> ✅
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if($item->catatan)
                                    <small class="d-block text-muted fst-italic bg-light p-1 rounded border">"{{ $item->catatan }}"</small>
                                @else 
                                    - 
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('prodi.surat.cetak', $item->id) }}" target="_blank" class="btn btn-dark btn-sm rounded-circle shadow-sm" title="Cetak Lembar Disposisi">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat surat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Konfirmasi Arsip via SweetAlert
    function konfirmasiArsip(id) {
        Swal.fire({
            title: 'Arsipkan Surat?',
            text: "Surat akan ditandai selesai (Arsip).",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            confirmButtonText: 'Ya, Arsip!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Manipulasi form untuk submit 'arsip'
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
@endpush