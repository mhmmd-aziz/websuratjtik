@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Daftar Surat Masuk – Admin JTIK</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>ID surat</th>
                <th>Pengirim</th>
                <th>Perihal</th>
                <th>Tanggal</th>
                <th>Isi Surat</th>   <!-- 🔥 DITAMBAHKAN -->
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($surat as $i => $s)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $s->id }}</td>
                <td>{{ $s->nama_pengirim }}</td>
                <td>{{ $s->perihal_surat }}</td>
                <td>{{ $s->created_at->format('d-m-Y') }}</td>

                <!-- 🔥 Kolom Isi Surat -->
                <td>
                    @if($s->file_surat)
                       <a href="{{ asset('storage/uploads/'.$s->file_surat) }}" target="_blank">

                            Lihat Surat
                        </a>
                    @else
                        <span class="text-danger">Tidak Ada File</span>
                    @endif
                </td>

                <td>
                    <!-- Tombol Disposisi -->
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalDisposisi{{ $s->id }}">
                        Disposisi
                    </button>
                </td>
            </tr>

            <!-- Modal Disposisi -->
            <div class="modal fade" id="modalDisposisi{{ $s->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('adminjtik.disposisi', $s->id) }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Disposisi Surat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                <div class="modal-body">
    <label class="form-label">Pilih Tujuan Disposisi:</label>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="tujuan[]" value="TI" id="ti{{ $s->id }}">
        <label class="form-check-label" for="ti{{ $s->id }}">Program Studi TI</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="tujuan[]" value="TRMM" id="trmm{{ $s->id }}">
        <label class="form-check-label" for="trmm{{ $s->id }}">Program Studi TRMM</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="tujuan[]" value="TRKJ" id="trkj{{ $s->id }}">
        <label class="form-check-label" for="trkj{{ $s->id }}">Program Studi TRKJ</label>
    </div>

</div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>

</div>
@endsection
