@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Disposisi Surat</h3>
    <p><b>Nomor Surat:</b> {{ $surat->nomor_surat }}</p>
    <p><b>Judul Surat:</b> {{ $surat->judul_surat }}</p>

    <form action="{{ route('surat.setPermission') }}" method="POST">
        @csrf

        <input type="hidden" name="id_surat" value="{{ $surat->id }}">

        <h4>Pilih Prodi yang Diizinkan</h4>

        @foreach($prodi as $p)
            <label>
                <input type="checkbox" 
                       name="prodi[]" 
                       value="{{ $p->id_prodi }}"
                       {{ in_array($p->id_prodi, $selectedProdi ?? []) ? 'checked' : '' }}>
                {{ $p->nama_prodi }}
            </label>
            <br>
        @endforeach

        <br>
        <button type="submit" class="btn btn-primary">Simpan Disposisi</button>
    </form>

</div>
@endsection
