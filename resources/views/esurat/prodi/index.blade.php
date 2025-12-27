<!DOCTYPE html>
<html>
<head>
    <title>Surat Masuk Prodi {{ $prodi }}</title>
</head>
<body>

<h1>Surat Masuk Prodi {{ $prodi }}</h1>

@foreach ($surat as $s)
<hr>
<h3>{{ $s->judul }}</h3>
<p>Status sekarang: <b>{{ $s->status }}</b></p>

<form action="/prodi/surat/update/{{ $s->id }}" method="POST">
    @csrf

    <label>
        <input type="radio" name="status" value="disposisi"> Disposisi
    </label><br>

    <label>
        <input type="radio" name="status" value="arsip"> Arsip
    </label><br><br>

    <button type="submit">Simpan</button>
</form>

@endforeach

</body>
</html>
