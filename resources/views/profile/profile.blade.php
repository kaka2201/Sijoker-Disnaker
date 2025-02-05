@extends('layouts.appuser')

@section('title', 'Profil')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="row justify-content-center">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <!-- Menggunakan storage asset untuk gambar profil -->
                    <img src="{{ $profile && $profile->foto ? asset('storage/' . $profile->foto) : asset('default-profile.png') }}" alt="Profile Image" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #007bff;">
                    
                    <h4 class="card-title mb-1">{{ $profile ? $profile->name : Auth::user()->name }}</h4>

                    <p class="text-muted mb-0">{{ $profile ? $profile->nomor : 'Nomor tidak tersedia' }}</p>
                    
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
                        <a href="{{ route('trainings') }}" class="d-flex align-items-center text-decoration-none text-dark">
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

        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $profile ? 'Perbarui Profil' : 'Tambah Profil' }}</h4>

                    <form action="{{ route('profile.storeOrUpdate') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $profile ? $profile->name : '') }}" required readonly>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $profile ? $profile->nik : '') }}" required readonly>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="ttl" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('ttl') is-invalid @enderror" id="ttl" name="ttl" value="{{ old('ttl', $profile ? $profile->ttl : '') }}" required readonly>
                                @error('ttl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required disabled>
                                    <option value="pria" {{ old('gender', $profile ? $profile->gender : '') == 'pria' ? 'selected' : '' }}>Pria</option>
                                    <option value="wanita" {{ old('gender', $profile ? $profile->gender : '') == 'wanita' ? 'selected' : '' }}>Wanita</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nomor" class="form-label">No Telpon</label>
                                <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor" value="{{ old('nomor', $profile ? $profile->nomor : '') }}" required readonly>
                                @error('nomor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <select class="form-select @error('kecamatan') is-invalid @enderror" id="kecamatan" name="kecamatan" required disabled>
                                    <option value="Batu" {{ old('kecamatan', $profile ? $profile->kecamatan : '') == 'Batu' ? 'selected' : '' }}>Batu</option>
                                    <option value="Bumiaji" {{ old('kecamatan', $profile ? $profile->kecamatan : '') == 'Bumiaji' ? 'selected' : '' }}>Bumiaji</option>
                                    <option value="Junrejo" {{ old('kecamatan', $profile ? $profile->kecamatan : '') == 'Junrejo' ? 'selected' : '' }}>Junrejo</option>
                                </select>
                                @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="desa" class="form-label">Desa/Kelurahan</label>
                                <select class="form-select @error('desa') is-invalid @enderror" id="desa" name="desa" required disabled>
                                    <!-- Desa akan diisi secara dinamis berdasarkan kecamatan -->
                                </select>
                                @error('desa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="jalan" class="form-label">Jalan, RT/RW</label>
                                <input type="text" class="form-control @error('jalan') is-invalid @enderror" id="jalan" name="jalan" value="{{ old('jalan', $profile ? $profile->jalan : '') }}" required readonly>
                                @error('jalan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                                <input type="text" class="form-control @error('pendidikan') is-invalid @enderror" id="pendidikan" name="pendidikan" value="{{ old('pendidikan', $profile ? $profile->pendidikan : '') }}" required readonly>
                                @error('pendidikan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="foto" class="form-label">Pas Foto</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" disabled>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-warning me-2" id="editButton">
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                            <button type="submit" class="btn btn-primary" id="saveButton" disabled>
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('editButton').addEventListener('click', function() {
        // Aktifkan semua input form dan tombol simpan
        let inputs = document.querySelectorAll('#profileForm input, #profileForm select');
        inputs.forEach(function(input) {
            input.removeAttribute('readonly');
            input.removeAttribute('disabled');
        });
        
        // Aktifkan tombol simpan
        document.getElementById('saveButton').removeAttribute('disabled');
    });

    const kecamatanSelect = document.getElementById('kecamatan');
    const desaSelect = document.getElementById('desa');

    const desaOptions = {
        "Batu": [
            "Oro-oro Ombo", "Pesanggrahan", "Sidomulyo", "Sumberejo", "Ngaglik", "Sisir", "Songgokerto", "Temas"
        ],
        "Bumiaji": [
            "Bulukerto", "Bumiaji", "Giripurno", "Gunungsari", "Pandanrejo", "Punten", "Sumber Brantas", "Sumbergondo", "Tulungrejo"
        ],
        "Junrejo": [
            "Beji", "Junrejo", "Mojorejo", "Pendem", "Tlekung", "Torongrejo", "Dadaprejo"
        ]
    };

    // Ketika kecamatan berubah, ubah opsi desa
    kecamatanSelect.addEventListener('change', function() {
        const kecamatan = this.value;
        const desaList = desaOptions[kecamatan];

        // Kosongkan opsi desa
        desaSelect.innerHTML = '';

        // Tambahkan opsi desa berdasarkan kecamatan yang dipilih
        desaList.forEach(function(desa) {
            const option = document.createElement('option');
            option.value = desa;
            option.textContent = desa;
            desaSelect.appendChild(option);
        });
    });

    // Trigger change event saat halaman dimuat jika sudah ada kecamatan yang dipilih
    window.addEventListener('load', function() {
        const selectedKecamatan = kecamatanSelect.value;
        if (selectedKecamatan) {
            kecamatanSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection