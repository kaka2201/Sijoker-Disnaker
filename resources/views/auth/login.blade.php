<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dinas Tenaga Kerja Kota Batu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }
        .container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 900px;
        }
        .card-body {
            padding: 3rem;
        }
        .image-container {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        .image-container::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            position: relative;
            z-index: 1;
        }
        h2 {
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 2rem;
        }
        .form-label {
            font-weight: 500;
            color: #34495e;
        }
        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid #bdc3c7;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
            border-color: #3498db;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: #7f8c8d;
        }
        .input-group .form-control {
            border-left: none;
        }
        .divider {
            border-top: 1px solid #ecf0f1;
            margin: 2rem 0;
        }
        .text-muted {
            color: #7f8c8d !important;
        }
        .text-primary {
            color: #3498db !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="row g-0">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="image-container h-100">
                        <img src="https://via.placeholder.com/600x400" alt="Login Image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Selamat Datang</h2>
                        <p class="text-center text-muted mb-4">Silakan masuk ke akun Anda</p>
                        
                        <!-- Tampilkan pesan error jika ada -->
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Tampilkan error untuk field email -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required placeholder="Masukkan email Anda">
                                </div>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tampilkan error untuk field password -->
                            <div class="mb-4">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required placeholder="Masukkan kata sandi Anda">
                                </div>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                                <label class="form-check-label" for="rememberMe">Ingat saya</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Masuk</button>
                        </form>
                        
                        <div class="divider"></div>
                        <p class="text-center">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none text-primary">Daftar</a></p>
                        <p class="text-center mt-2"><a href="#" class="text-decoration-none text-muted">Lupa kata sandi?</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
