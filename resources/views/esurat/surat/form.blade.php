<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kirim Surat | JTIK E-Surat</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://unpkg.com/feather-icons"></script>

<style>
/* Definisikan variabel warna */
:root {
    --primary: #bf00ff;
    --bg: #fff;
}

body {
    font-family: 'Poppins', sans-serif;
    /* Latar belakang sama dengan Lacak Surat */
    background: 
        linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
        url('{{ asset("foto/tik.jpg") }}') center/cover no-repeat;
    background-attachment: fixed;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* Navbar Styling */
.navbar-brand {
    position: absolute;
    left: 20px;
}
.navbar-brand img {
    margin-left: 90px;
}
.navbar-brand span {
    font-size: 2rem;
    color: #bf00ff;
    font-weight: 700;
}

/* Mengatur ukuran font Nav Link agar besar dan seragam */
        .navbar-nav .nav-link {
            font-size: 2rem; /* lebih besar */
            font-weight: 700;
            padding: 1rem 1.5rem;
             margin-right: 1.5rem;
        }
.navbar-nav .active-link {
    color: var(--primary) !important;
}


/* Form Container */
.form-container {
    margin-top: 120px; 
    display: flex;
    justify-content: center;
    padding: 20px;
    flex-grow: 1;
}

form {
    /* UBAH: Latar belakang menjadi hitam semi-transparan */
    background: rgba(34, 34, 34, 0.85); 
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.5); 
    width: 100%;
    max-width: 500px;
}

form h2 {
    text-align: center;
    margin-bottom: 20px;
    color: var(--primary); /* UBAH: Judul menggunakan warna ungu primary */
}

label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #fff; /* UBAH: Teks label menjadi putih */
}

input[type="text"],
input[type="email"],
input[type="file"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 20px;
    /* UBAH: Input field gelap dengan teks putih */
    background-color: #333; 
    border: 1px solid #555;
    color: white; /* UBAH: Warna teks input menjadi putih */
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 15px;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="file"]:focus {
    border-color: var(--primary);
    box-shadow: 0 0 5px rgba(191, 0, 255, 0.5);
    outline: none;
}

button[type="submit"] {
    width: 100%;
    padding: 12px;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

button[type="submit"]:hover {
    background: #a500d4;
}

/* Footer Styling */
footer {
    margin-top: auto;
    background: #343a40;
    color: #fff;
    padding: 50px 0;
}

footer a {
    color: #bf00ff;
    text-decoration: none;
    font-size: 1.2rem;
}

footer .socials a {
    margin-right: 15px;
    font-size: 1.5rem;
}

footer p {
    font-size: 1.1rem;
}
        

@media (max-width: 576px) {
    .navbar-nav .nav-link {
        font-size: 1.2rem;
        padding: 0.5rem 1rem;
    }

    form {
        padding: 20px;
    }
}
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('foto/logo_tik.jpeg') }}" alt="Logo TIK" width="60" style="margin-left:90px;">
             <span>JTIK E-Surat</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li> 
                <li class="nav-item"><a class="nav-link active-link" href="{{ route('surat.create') }}">Kirim Surat</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('surat.lacak') }}">Status Surat</a></li> 
                <li class="nav-item"><a class="nav-link" href="/#contact">Kontak Bantuan</a></li> 
            </ul>
        </div>
    </div>
</nav>

<div class="form-container">
    <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- NOTIFIKASI SUKSES --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading"><i class="bi bi-check-circle-fill"></i> Berhasil!</h4>
        <p>{{ session('success') }}</p>
        <hr>
        <p class="mb-0 fs-5">{!! session('message_detail') !!}</p> 
        
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

        <h2>Kirim Surat</h2>

        <label>Nama Pengirim:</label>
        <input type="text" name="nama_pengirim" required>

        <div class="mb-3">
    <label class="form-label fw-bold">Sifat Surat</label>
    <select name="sifat_surat" class="form-select" required>
        <option value="biasa">🟢 Biasa</option>
        <option value="segera">🟡 Segera</option>
        <option value="penting">🔴 Penting / Rahasia</option>
    </select>
    <div class="form-text">Pilih prioritas surat agar admin tahu urgensinya.</div>
</div>

        <label>Perihal Surat:</label>
        <input type="text" name="perihal_surat" required>

        <label>Email Pengirim:</label>
        <input type="email" name="email" required>

        <label>Upload File Surat (PDF/JPG/etc):</label>
        <input type="file" name="file_surat">

        <button type="submit">Kirim Surat</button>
    </form>
</div>

<footer class="text-center text-white mt-5">
    <div class="bg-dark py-4">
        <div class="container">
            <div class="mb-3">
                <a href="#" class="text-white me-3"><i data-feather="instagram"></i></a>
                <a href="#" class="text-white me-3"><i data-feather="twitter"></i></a>
                <a href="#" class="text-white"><i data-feather="facebook"></i></a>
            </div>
            <div>
                <p>&copy; {{ date('Y') }} AA Team. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    feather.replace()
</script>
</body>
</html>