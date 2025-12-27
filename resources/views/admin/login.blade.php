<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - E-Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            /* Background gradasi biru-ungu biar modern */
            background: linear-gradient(135deg, #1e3c72 0%, #a20ac0ff 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-login {
            border: none;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: none;
            padding: 2rem 1rem 1rem;
            text-align: center;
        }
        .logo-icon {
            font-size: 3rem;
            color: #1e3c72;
            margin-bottom: 10px;
        }
        .btn-primary {
            background-color: #1e3c72;
            border: none;
            padding: 10px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #162d55;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #1e3c72;
            background-color: #fff;
        }
    </style>
</head>
<body>

    <div class="card card-login">
        <div class="card-header">
            <div class="logo-icon">🔒</div>
            <h4 class="fw-bold text-dark">Login Admin</h4>
            <p class="text-muted small">Sistem E-Surat</p>
        </div>
        
        <div class="card-body p-4 pt-2">
            <form method="POST" action="{{ route('admin.login.process') }}">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger py-2 small text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-3">
                    <label for="username" class="form-label small text-uppercase fw-bold text-muted">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label small text-uppercase fw-bold text-muted">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">
                        MASUK
                    </button>
                </div>
            </form>
        </div>
        <div class="card-footer bg-white text-center py-3 border-0">
            <small class="text-muted">&copy; {{ date('Y') }} Politeknik Negeri Lhokseumawe</small>
        </div>
    </div>

</body>
</html>