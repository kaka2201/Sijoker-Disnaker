<div class="col-md-3 mb-4">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <!-- Menggunakan storage asset untuk gambar profil -->
            <img src="{{ $profile->foto ? asset('storage/' . $profile->foto) : asset('image/default_profile.jpg') }}" alt="Profile Image" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #007bff;">
            
            <h4 class="card-title mb-1">{{ $profile->name ? $profile->name : Auth::user()->name }}</h4>

            <p class="text-muted mb-0">{{ $profile->nomor ? $profile->nomor : 'Nomor tidak tersedia' }}</p>
            
            <p class="text-muted">
                @if($profile->jalan && $profile->desa && $profile->kecamatan )
                    {{ $profile->jalan }}, {{ $profile->desa }}, {{ $profile->kecamatan }}
                @else
                    Alamat tidak tersedia
                @endif
            </p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="{{ route('profile.index') }}" class="d-flex align-items-center text-decoration-none text-dark">
                    <i class="fas fa-user me-2"></i> Profil
                </a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('profile.documents') }}" class="d-flex align-items-center text-decoration-none text-dark">
                    <i class="fas fa-file-alt me-2"></i> Lengkapi Dokumen
                </a>
            </li>
            @if (Auth::user()->hasRole('admin')||Auth::user()->hasRole('super_admin'))
            <li class="list-group-item">
                <a href="{{ route('trainings.index') }}" class="d-flex align-items-center text-decoration-none text-dark">
                    <i class="fas fa-file-alt me-2"></i> Pelatihan Terdaftar
                </a>
            </li>
            @endif
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