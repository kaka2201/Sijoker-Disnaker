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
            max-width: 1000px;
            width: 90%;
        }
        .image-container {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        h2 {
            color: #2c3e50;
            font-weight: bold;
            text-align: center;
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
        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
        }
        .divider {
            border-top: 1px solid #ecf0f1;
            margin: 10px 0;
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
                <div class="col-md-6 d-none d-md-block">
                    <div class="image-container h-100" style="background-image: url('{{ asset('image/maxresdefault.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                        {{-- <img src="{{ asset ('image/maxresdefault.jpg') }}" alt="Login Image"> --}}
                    </div>
                </div>
                <div class="col-md-6 p-5">
                    <h2>Selamat Datang</h2>
                    <p class="text-muted text-center">Silakan masuk ke akun Anda</p>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-group mb-4">
                            <input type="password" name="password" class="form-control" id="password" required>
                            <span class="input-group-text" onclick="togglePassword('password', 'togglePasswordIcon')">
                                <i id="togglePasswordIcon" class="fas fa-eye"></i>
                            </span>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
                    </form>
                    <div class="divider"></div>
                    <p class="text-center">Belum punya akun? <a href="{{ route('register') }}" class="text-primary">Daftar</a></p>
                    <div class="divider"></div>
                    <p class="text-center">Kembali Ke <a href="{{ url('/') }}" class="text-primary">Home</a></p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
    
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>    
</body>
</html>
