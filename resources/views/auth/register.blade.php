    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrasi - Dinas Tenaga Kerja Kota Batu</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 3rem 0;
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
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="image-container h-100" style="background-image: url('{{ asset('image/maxresdefault.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            {{-- <img src="{{ asset ('image/maxresdefault.jpg') }}" alt="Login Image"> --}}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body">
                            <h2 class="text-center mb-4">Buat Akun Baru</h2>
                            <p class="text-center text-muted mb-4">Silakan isi formulir di bawah ini untuk mendaftar</p>
                            <form id="registerForm" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" name="name" class="form-control" id="name" required placeholder="Masukkan nama lengkap Anda">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Alamat Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control" id="email" required placeholder="Masukkan alamat email Anda">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata Sandi</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password" class="form-control" id="password" required placeholder="Buat kata sandi Anda" onkeyup="validatePassword()">
                                        <span class="input-group-text" onclick="togglePassword('password', 'togglePasswordIcon')">
                                            <i id="togglePasswordIcon" class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                    <div id="passwordWarning" class="text-danger mt-2" style="display: none;">
                                        Kata sandi harus lebih dari 8 karakter.
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required placeholder="Konfirmasi kata sandi Anda" onkeyup="validatePasswordMatch()">
                                        <span class="input-group-text" onclick="togglePassword('password_confirmation', 'toggleConfirmIcon')">
                                            <i id="toggleConfirmIcon" class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                    <div id="passwordMismatchWarning" class="text-danger mt-2" style="display: none;">
                                        Konfirmasi kata sandi tidak sesuai.
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Daftar</button>
                            </form>
                            <div class="divider"></div>
                            <p class="text-center mt-4">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none text-primary">Masuk</a></p>
                            <div class="divider"></div>
                            <p class="text-center">Kembali Ke <a href="{{ url('/') }}" class="text-primary">Home</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('registerForm').addEventListener('submit', function(event) {
                const password = document.getElementById('password').value;
                const passwordConfirmation = document.getElementById('password_confirmation').value;
                const passwordWarning = document.getElementById('passwordWarning');
                const passwordMismatchWarning = document.getElementById('passwordMismatchWarning');
                
                let valid = true;

                if (password.length < 8) {
                    passwordWarning.style.display = 'block';
                    valid = false;
                } else {
                    passwordWarning.style.display = 'none';
                }

                if (password !== passwordConfirmation) {
                    passwordMismatchWarning.style.display = 'block';
                    valid = false;
                } else {
                    passwordMismatchWarning.style.display = 'none';
                }

                if (!valid) {
                    event.preventDefault(); // Prevent form submission
                }
            });
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
        
            function validatePassword() {
                const password = document.getElementById("password").value;
                const warning = document.getElementById("passwordWarning");
            
                if (password.length < 8) {
                    warning.style.display = "block";
                } else {
                    warning.style.display = "none";
                }
            }
        
            function validatePasswordMatch() {
                const password = document.getElementById("password").value;
                const confirmPassword = document.getElementById("password_confirmation").value;
                const warning = document.getElementById("passwordMismatchWarning");
            
                if (confirmPassword && password !== confirmPassword) {
                    warning.style.display = "block";
                } else {
                    warning.style.display = "none";
                }
            }
        </script>
    </body>
    </html>