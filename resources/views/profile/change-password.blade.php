@extends('layouts.appuser')

@section('title', 'Ganti Kata Sandi')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="row justify-content-center">
         <!-- Sidebar -->
         <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <img src="{{ $profile && $profile->foto ? asset('storage/' . $profile->foto) : asset('default-profile.png') }}" alt="Profile Image" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #007bff;">
                    
                    <h4 class="card-title mb-1">{{ $profile ? $profile->name : Auth::user()->name }}</h4>

                    <!-- Mengganti mahasiswa dengan nomor telepon -->
                    <p class="text-muted mb-0">{{ $profile ? $profile->nomor : 'Nomor tidak tersedia' }}</p>
                    
                    <!-- Mengganti Universitas Muhammadiyah Malang dengan alamat lengkap -->
                    <p class="text-muted">
                        @if($profile)
                            {{ $profile->jalan }}, {{ $profile->desa }}, {{ $profile->kecamatan }}
                        @else
                            'Alamat tidak tersedia'
                        @endif
                    </p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="{{ route('profile') }}" class="d-flex align-items-center text-decoration-none text-dark">
                            <i class="fas fa-user me-2"></i> Profil
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('profile.documents') }}" class="d-flex align-items-center text-decoration-none text-dark">
                            <i class="fas fa-file-alt me-2"></i> Lengkapi Dokumen
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('profile.trainings') }}" class="d-flex align-items-center text-decoration-none text-dark">
                            <i class="fas fa-file-alt me-2"></i> Pelatihan Terdaftar
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('profile.change-password') }}" class="d-flex align-items-center text-decoration-none text-dark">
                            <i class="fas fa-key me-2"></i> Ganti Kata Sandi
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="d-flex align-items-center text-decoration-none text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">Ubah Kata Sandi</h4>
                    <p>Silakan ubah kata sandi dengan yang baru</p>

                    <!-- Form untuk mengubah kata sandi -->
                    <form action="{{ route('profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Pesan Error -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Pesan Sukses -->
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="mb-3">
                            <label for="current-password" class="form-label">Kata sandi sekarang</label>
                            <input type="password" class="form-control" id="current-password" name="current_password" placeholder="Kata sandi sekarang" required>
                        </div>
                        <div class="mb-3">
                            <label for="new-password" class="form-label">Kata sandi baru</label>
                            <input type="password" class="form-control" id="new-password" name="new_password" placeholder="Kata sandi baru" required>
                            <div class="form-text">Minimal 8 karakter dan mengandung kombinasi huruf kecil, huruf besar, dan angka</div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Ketik ulang kata sandi baru</label>
                            <input type="password" class="form-control" id="confirm-password" name="new_password_confirmation" placeholder="Ketik ulang kata sandi baru" required>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
