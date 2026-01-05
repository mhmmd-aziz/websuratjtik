<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard E-Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; overflow-x: hidden; }
        
        /* SIDEBAR STYLE */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            color: white;
            position: fixed;
            top: 0; left: 0;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-brand {
            padding: 20px;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.1);
        }

        .sidebar-menu { padding: 20px 10px; }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 5px;
            transition: 0.3s;
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            transform: translateX(5px);
        }
        
        .sidebar-link i { margin-right: 12px; font-size: 1.2rem; }

        /* CONTENT AREA */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            transition: all 0.3s;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .sidebar.active { margin-left: 0; }
            .main-content { margin-left: 0; }
            .main-content.active { margin-left: 260px; } /* Opsional: geser konten */
        }

        /* HEADER ATAS (Mobile Toggle) */
        .top-navbar {
            background: white;
            padding: 15px 30px;
            margin-bottom: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-envelope-paper-fill text-warning me-2"></i> E-SURAT
        </div>
        
        <div class="sidebar-menu">
            @if(session('admin_role') == 'admin_jtik')
                <div class="small text-uppercase text-white-50 mb-2 px-3" style="font-size: 11px; letter-spacing: 1px;">Admin Pusat</div>
                
                <a href="{{ route('admin.jtik.index') }}" class="sidebar-link {{ request()->is('admin/jtik/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('adminjtik.sampah.index') }}" class="sidebar-link {{ request()->is('adminjtik/sampah*') ? 'active' : '' }}">
                    <i class="bi bi-trash"></i> Tong Sampah
                </a>
                <a href="{{ route('adminjtik.export') }}" class="sidebar-link">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Laporan Excel
                </a>

            @else
                <div class="small text-uppercase text-white-50 mb-2 px-3" style="font-size: 11px; letter-spacing: 1px;">Admin Unit</div>
                
                <a href="{{ route('admin.prodi.index') }}" class="sidebar-link {{ request()->is('admin/prodi/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i> Dashboard Prodi
                </a>
            @endif

            <hr class="border-light opacity-25 my-3">

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link w-100 bg-transparent border-0 text-start text-danger fw-bold">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="top-navbar d-flex">
            <button class="btn btn-light d-md-none" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="fw-bold text-secondary d-none d-md-block">
                @if(session('admin_role') == 'admin_jtik')
                    Admin JTIK (Pusat)
                @else
                    Admin Prodi {{ strtoupper(str_replace('prodi_', '', session('admin_role'))) }}
                @endif
            </div>
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 35px; height: 35px;">
                    A
                </div>
                <span class="small fw-bold text-dark">Halo, Admin</span>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // Global Alert SweetAlert
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{!! session('success') !!}", showConfirmButton: false, timer: 2000, confirmButtonColor: '#2c3e50' });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}" });
        @endif
    </script>
    
    @stack('scripts') 

</body>
</html>