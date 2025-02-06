@extends('layouts.appuser')

@section('title', 'Dinas Tenaga Kerja Kota Batu - Pelatihan Tenaga Kerja')

@push('styles')
    <!-- Custom CSS -->
    <style>
        /* body {
            font-family: 'Poppins', sans-serif;
            color: #333;
        } */
        .bg-gradient-primary {
            background-color: #FFFFFF; /* Mengubah latar belakang menjadi putih */
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }
        .hover-zoom img {
            transition: transform 0.4s ease;
            border-radius: 12px;
        }
        .hover-zoom:hover img {
            transform: scale(1.05);
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-slide-up {
            animation: slideUp 0.8s ease-out;
        }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .btn-primary {
            background-color: #2575FC;
            border: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            border-radius: 50px;
        }
        .btn-primary:hover {
            background-color: #6A11CB;
            box-shadow: 0 8px 15px rgba(106, 17, 203, 0.3);
        }
        .header-title {
            font-size: 2.5rem;
            color: black;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .header-subtitle {
            font-size: 1.25rem;
            color: black;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 50px;
            border: 1px solid #ddd;
            padding: 15px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #6A11CB;
            box-shadow: none;
        }
        .feature-icon {
            color: #6A11CB;
            margin-bottom: 20px;
        }
        .counter {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2575FC;
        }

        .logo-container {
            margin-right: 15px;
        }

        .text-container {
            text-align: center;
            color: #2575FC;
        }

        @media (max-width: 768px) {
            .container.d-flex {
                flex-direction: column;
                text-align: center;
            }

            .logo-container {
                margin-bottom: 20px;
            }
        }
    </style>
@endpush
@section('content')

    <!-- Header Start -->
        <div class="bg-gradient-primary py-5">
            <div class="container d-flex align-items-center justify-content-center py-5">
                <!-- Logo Kota Batu (di kiri) -->
                <div class="logo-container mr-3">
                    <img class="img-fluid" src="{{ asset('image/logo_batu.png') }}" alt="Logo Kota Batu" style="height: 200px;">
                </div>
                <!-- Teks Tengah -->
                <div class="text-container">
                    <h1 class="header-title animate-fade-in">Dinas Tenaga Kerja Kota Batu</h1>
                    <h2 class="header-subtitle animate-slide-up">Pelatihan Tenaga Kerja Berbasis Kompetensi</h2>
                </div>
                <!-- Logo Disnaker (di kanan) -->
                <div class="logo-container ml-3">
                    <img class="img-fluid" src="{{ asset('image/logo.png') }}" alt="Logo Disnaker Hitam" style="height: 200px; margin-left: 30px;">
                </div>
            </div>
        </div>
    <!-- Header End -->

<!-- About Start -->
        <!-- About Start -->
        <div class="bg-about">
            <div class="container py-5 text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-8 mb-4 mb-lg-0 animate-fade-in">
                        <h2 class="font-weight-bold mb-4">Tentang Dinas Tenaga Kerja Kota Batu</h2>
                        <p class="text-muted">Dinas Tenaga Kerja Kota Batu berkomitmen untuk meningkatkan kualitas dan keterampilan tenaga kerja melalui program pelatihan berkualitas. Kami berupaya menciptakan tenaga kerja yang kompeten dan siap bersaing di pasar kerja.</p>
                    </div>
                </div>
                <div class="row mt-4 justify-content-center">
                    <div class="col-md-4 mb-3 text-center">
                        <h4 class="counter">10</h4>
                        <p class="text-muted">Program Pelatihan</p>
                    </div>
                    <div class="col-md-4 mb-3 text-center">
                        <h4 class="counter">15</h4>
                        <p class="text-muted">Instruktur Ahli</p>
                    </div>
                    <div class="col-md-4 mb-3 text-center">
                        <h4 class="counter">500</h4>
                        <p class="text-muted">Peserta Terlatih</p>
                    </div>
                </div>
            </div>
        </div>
<!-- About End -->

<!-- About End -->

    <!-- About End -->

    <!-- Features Start -->
    <div class="bg-light py-5">
        <div class="container py-5">
            <h2 class="text-center font-weight-bold mb-5 animate-fade-in">Mengapa Memilih Program Kami</h2>
            <div class="row">
                <div class="col-lg-4 mb-4 animate-slide-up">
                    <div class="card h-100 hover-zoom">
                        <div class="card-body text-center">
                            <i class="fas fa-graduation-cap fa-3x feature-icon"></i>
                            <h4 class="font-weight-bold mb-3">Instruktur Berpengalaman</h4>
                            <p class="text-muted">Pelatihan dipandu oleh instruktur ahli dengan pengalaman industri yang relevan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4 animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="card h-100 hover-zoom">
                        <div class="card-body text-center">
                            <i class="fas fa-certificate fa-3x feature-icon"></i>
                            <h4 class="font-weight-bold mb-3">Sertifikasi BNSP</h4>
                            <p class="text-muted">Dapatkan sertifikat resmi yang diakui industri setelah menyelesaikan pelatihan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4 animate-slide-up" style="animation-delay: 0.4s;">
                    <div class="card h-100 hover-zoom">
                        <div class="card-body text-center">
                            <i class="fas fa-briefcase fa-3x feature-icon"></i>
                            <h4 class="font-weight-bold mb-3">Peluang Karir</h4>
                            <p class="text-muted">Akses ke jaringan mitra industri untuk meningkatkan peluang kerja Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->

    <!-- Programs Start -->
    <div class="container py-5" id="pelatihan-tersedia">
        <h2 class="text-center font-weight-bold mb-5 animate-fade-in">Program Pelatihan Tersedia</h2>
        <div class="row">
            @if($trainings->isEmpty())
                <p class="text-center">Tidak ada program pelatihan yang tersedia saat ini.</p>
            @else
                @foreach ($trainings as $training)
                <div class="col-lg-4 mb-4 animate-slide-up" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                    <div class="card h-100 hover-zoom position-relative">
                        @if($training->image)
                            <img src="{{ asset('storage/' . $training->image) }}" class="card-img-top" alt="{{ $training->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/training-default.jpg') }}" class="card-img-top" alt="{{ $training->title }}" style="height: 200px; object-fit: cover;">
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title font-weight-bold">{{ $training->title }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($training->description, 100) }}</p>
                            <p class="card-text">
                                <small class="text-muted">Lokasi: {{ $training->location }}</small><br>
                                <small class="text-muted">Tanggal Mulai: {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}</small><br>
                                <small class="text-muted">Kapasitas: {{ $training->capacity }} Peserta</small>
                            </p>
                            <div class="mt-auto">
                                <div class="position-absolute bottom-0 end-0 p-3">
                                    <a href="{{ route('course') }}" class="btn btn-outline-info btn-sm rounded-pill">Detail</a>
                                    <a href="{{ route('pelatihan.preview', $training->id) }}" class="btn btn-outline-success btn-sm rounded-pill btn-glow">Daftar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
    <!-- Programs End -->

    <!-- Important Information Start -->
    <div class="bg-light py-5">
        <div class="container py-5">
            <h2 class="text-center font-weight-bold mb-5 animate-fade-in">Hal-hal Penting untuk Diperhatikan</h2>
            <ul class="list-group">
                <li class="list-group-item">1. Pastikan Anda telah mendaftar akun untuk mengakses pelatihan.</li>
                <li class="list-group-item">2. Lengkapi profil Anda agar mudah dalam proses pendaftaran.</li>
                <li class="list-group-item">3. Siapkan dokumen-dokumen penting yang diperlukan untuk pendaftaran.</li>
                <li class="list-group-item">4. Jika ada pertanyaan, jangan ragu untuk menghubungi kami.</li>
            </ul>
        </div>
    </div>
    <!-- Important Information End -->

    <!-- Contact Start -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0 animate-slide-up">
                <h2 class="font-weight-bold mb-4">Hubungi Kami</h2>
                <p class="text-muted mb-4">Jika Anda memiliki pertanyaan atau membutuhkan informasi lebih lanjut, jangan ragu untuk menghubungi kami:</p>
                <div class="d-flex mb-3">
                    <i class="fas fa-map-marker-alt text-primary mr-3 mt-1"></i>
                    <p class="text-muted">Jl. Panglima Sudirman No.507, Pesanggrahan, Kec. Batu, Kota Batu, Jawa Timur 65313</p>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-phone-alt text-primary mr-3 mt-1"></i>
                    <p class="text-muted">+62 822 2222 2222</p>
                </div>
                <div class="d-flex">
                    <i class="fas fa-envelope text-primary mr-3 mt-1"></i>
                    <p class="text-muted">info@disnakerkotabatu.go.id</p>
                </div>
            </div>
            <div class="col-lg-6 animate-slide-up" style="animation-delay: 0.2s;">
                <form class="shadow-lg p-4 rounded bg-white">
                    <div class="form-group">
                        <input type="text" class="form-control rounded-pill" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control rounded-pill" placeholder="Alamat Email" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control rounded" rows="5" placeholder="Pesan" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Custom JS -->
    <script>
        // Animate counter
        $('.counter').each(function() {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 2000,
                easing: 'swing',
                step: function(now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });

        // Animate elements on scroll
        $(window).scroll(function() {
            $('.animate-fade-in, .animate-slide-up').each(function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('animated');
                }
            });
        });
    </script>
@endsection
