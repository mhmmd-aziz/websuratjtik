<h2>Daftar Surat Pending</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Judul Surat</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>

    @forelse ($surat as $s)
    <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->judul }}</td>
        <td>{{ $s->created_at }}</td>
        <td><a href="{{ route('surat.show', $s->id) }}">Lihat</a></td>
    </tr>
    @empty
    <tr>
        <td colspan="4">Tidak ada surat pending.</td>
    </tr>
    @endforelse
</table>
