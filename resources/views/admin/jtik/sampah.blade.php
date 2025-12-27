<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tong Sampah Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light p-4">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-danger"><i class="bi bi-trash3-fill"></i> Tong Sampah Surat</h3>
        <a href="{{ route('admin.jtik.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-4 shadow-sm border-danger">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Dihapus Pada</th>
                        <th class="text-center">Opsi Pemulihan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sampah as $s)
                    <tr>
                        <td>{{ $s->nama_pengirim }}</td>
                        <td>{{ $s->perihal_surat }}</td>
                        <td class="text-danger small">{{ $s->deleted_at->format('d M Y H:i') }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('adminjtik.sampah.restore', $s->id) }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-arrow-counterclockwise"></i> Restore
                                </a>

                                <form onsubmit="return confirm('Yakin hapus permanen? File juga akan hilang!')" 
                                      action="{{ route('adminjtik.sampah.force', $s->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-x-circle"></i> Musnahkan
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-trash fs-1 d-block mb-2"></i>
                            Tong sampah kosong. Bagus!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>