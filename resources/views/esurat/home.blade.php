<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JTIK E-Surat | Politeknik Negeri Lhokseumawe</title> 

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
        }

        .navbar-brand {
            position: absolute;
            left: 20px;
            display: flex;
            align-items: center;
            font-weight: 700;
        }

        .navbar-brand span {
            font-size: 2rem;
            color: #bf00ff;
            font-weight: 700;
            margin-left: 10px;
        }

        .navbar-nav {
            margin: 0 auto;
        }

        .navbar-nav .nav-link {
            font-size: 2rem; /* lebih besar */
            font-weight: 700;
            padding: 1rem 1.5rem;
             margin-right: 1.5rem;
        }

        /* Hero Section */
        .hero {
            background: url('{{ asset("foto/tik.jpg") }}') center/cover no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
            position: relative;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.5);
        }

        .hero .content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hero h1 {
            font-size: 7rem; /* lebih besar */
            font-weight: 800;
        }

        .hero h1 span {
            color: #bf00ff;
        }

        .hero p.lead {
            font-size: 2rem; /* lebih besar */
            margin-top: 20px;
        }

        .hero .btn-cta {
            font-size: 1.5rem; /* lebih besar */
            padding: 18px 45px;
            border-radius: 10px;
            background-color: #bf00ff;
            color: #fff;
            font-weight: 700;
            margin-top: 20px;
            transition: 0.3s;
        }

        .hero .btn-cta:hover {
            background-color: #040404ff;
        }

        /* About Section */
        #about {
            padding: 100px 0;
              font-size: 2rem;
        }

        #about h2 {
            font-size: 3rem;
            font-weight: 800;
        }

        #about h2 span {
            color: #bf00ff;
        }

        #about h3 {
            font-size: 2rem;
            font-weight: 700;
        }

        #about p {
            font-size: 1.2rem;
            line-height: 1.8;
        }

        /* Contact Section */
        #contact {
            padding: 100px 0;
            background: #f8f9fa;
        }

        #contact h2 {
            font-size: 2.8rem;
            font-weight: 700;
        }

        #contact p {
            font-size: 1.3rem;
        }

        .contact .form-control {
            border-radius: 0.5rem;
            font-size: 1.1rem;
        }

        .contact .btn {
            border-radius: 0.5rem;
            font-size: 1.2rem;
            padding: 12px 25px;
        }

        /* Footer */
        footer {
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

        /* Responsive */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 3rem;
            }
            .hero p.lead {
                font-size: 1.5rem;
            }
            .hero .btn-cta {
                font-size: 1.2rem;
                padding: 15px 35px;
            }
            #about h2 {
                font-size: 2.2rem;
            }
            #about h3 {
                font-size: 1.5rem;
            }
            #contact h2 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 2rem;
            }
            .hero p.lead {
                font-size: 1.2rem;
            }
            .hero .btn-cta {
                font-size: 1rem;
                padding: 12px 25px;
            }
            #about h2 {
                font-size: 1.8rem;
            }
            #about h3 {
                font-size: 1.3rem;
            }
            #contact h2 {
                font-size: 2rem;
            }
        }

    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#home" style="padding-left:0;">
            <img src="{{ asset('foto/logo_tik.jpeg') }}" alt="Logo TIK" width="60" style="margin-left:90px;">
             <span style="font-size: 2rem; color:#bf00ff; font-weight:700;">JTIK E-Surat</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('surat.create') }}">Kirim Surat</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('surat.lacak') }}">Status Surat</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Kontak Bantuan</a></li>

                <!-- TOMBOL LOGIN ADMIN -->
                <div class="d-flex ms-auto">
                    <a href="{{ route('admin.login') }}" id="login-button"><i data-feather="user"></i></a> 
                        Login Admin
                    </a>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero" id="home">
    <div class="content">
        <h1>Selamat Datang di <span>Jurusan Teknologi Informasi dan Komputer </span>Politeknik Negeri Lhokseumawe</h1>
        <p class="lead">Sistem Administrasi Surat Digital yang Cepat, Transparan, dan Efisien.</p>
    </div>
</section>

<!-- About Section -->
<section id="about" class="container">
    <h2 class="text-center mb-5"><span>Tentang</span> Sistem</h2>
    <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="{{ asset('foto/surat.jpg') }}" alt="Ilustrasi Digitalisasi" class="img-fluid rounded">
        </div>
        <div class="col-md-6">
            <h3>JTIK E-SURAT</h3>
            <p>Sistem E-Surat jurusan TIK hadir untuk mempermudah proses penerimaan, pengarsipan, dan disposisi surat masuk dari berbagai instansi luar kampus.</p>
            <p>JTIK E-Surat mengubah proses surat-menyurat manual menjadi alur kerja digital yang aman dan cepat. Surat penting langsung mencapai unit tujuan dengan efisien.</p>
            <p>Tujuan kami: layanan administrasi surat mudah diakses, cepat diproses, dan terpercaya.</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact container">
    <h2 class="text-center mb-4"><span>Kontak</span> Bantuan Teknis</h2>
    <p class="text-center mb-5">Hubungi tim Admin Tata Usaha Jurusan TIK untuk pertanyaan terkait sistem E-Surat.</p>
    <div class="row">
        <div class="col-md-6 mb-4 mb-md-0">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.686561148813!2d96.96963287474966!3d5.201479836798059!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304772b2207b5399%3A0xc3b5e439d09c3132!2sPoliteknik%20Negeri%20Lhokseumawe!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                allowfullscreen="" loading="lazy" class="w-100 rounded" style="height:400px;"></iframe>
        </div>
        <div class="col-md-6">
            <form action="https://formspree.io/f/mldarvpb" method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Instansi/Pengirim</label>
                    <input type="text" class="form-control" name="nama_instansi" placeholder="Nama Instansi/Pengirim">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Anda</label>
                    <input type="email" class="form-control" name="email" placeholder="Email Anda">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Perihal Bantuan</label>
                    <input type="text" class="form-control" name="message" placeholder="Perihal Bantuan">
                </div>
                <button type="submit" class="btn btn-primary w-100">Kirim Pesan Bantuan</button>
            </form>
        </div>
    </div>
</section>

<!-- Footer -->
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    feather.replace()
</script>
</body>
</html>
