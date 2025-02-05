@extends('layouts.appuser')

@section('title', 'Lengkapi Dokumen')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="row justify-content-center">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
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

        <!-- Content Area -->
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">Lengkapi Data Diri</h4>
                    <div class="alert alert-warning">
                        <strong>Perhatian!</strong> Pastikan kamu mengumpulkan dokumen sesuai ketentuan, ya!
                        <ul>
                            <li>Kesalahan data pada dokumen berakibat penolakan</li>
                            <li>Pemalsuan dokumen berakibat masuk ke daftar blacklist</li>
                        </ul>
                    </div>

                    <!-- Form untuk dokumen -->
                    <form action="{{ route('profile.documents.storeOrUpdate') }}" method="POST" enctype="multipart/form-data" id="documentForm">
                        @csrf

                        <!-- KTP -->
                        <div class="mb-3 row">
                            <label for="ktp" class="form-label col-md-8">KTP (Wajib)
                                <span class="badge 
                                    @if($document && $document->ktp_status == 'confirmed') bg-success
                                    @elseif($document && $document->ktp_status == 'rejected') bg-danger
                                    @elseif($document && $document->ktp_status == 'pending') bg-warning
                                    @else bg-secondary @endif">
                                    @if($document && $document->ktp_status == 'confirmed')
                                        Terverifikasi
                                    @elseif($document && $document->ktp_status == 'rejected')
                                        Tidak Sesuai
                                    @elseif($document && $document->ktp_status == 'pending')
                                        Menunggu Konfirmasi
                                    @else
                                        Silahkan Upload Dokumen
                                    @endif
                                </span>
                            </label>
                            <div class="col-md-12">
                                <input type="file" class="form-control" id="ktp" name="ktp" 
                                    @if($document && in_array($document->ktp_status, ['confirmed', 'pending'])) disabled @endif
                                    onchange="checkFileSize(this)">
                                <small class="text-muted">Ukuran maksimum 1MB (format: pdf)</small>
                                @if($document && $document->ktp)
                                    <p class="text-muted">Dokumen saat ini: {{ basename($document->ktp) }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Kartu Keluarga -->
                        <div class="mb-3 row">
                            <label for="kk" class="form-label col-md-8">Kartu Keluarga (Wajib)
                                <span class="badge 
                                    @if($document && $document->kk_status == 'confirmed') bg-success
                                    @elseif($document && $document->kk_status == 'rejected') bg-danger
                                    @elseif($document && $document->kk_status == 'pending') bg-warning
                                    @else bg-secondary @endif">
                                    @if($document && $document->kk_status == 'confirmed')
                                        Terverifikasi
                                    @elseif($document && $document->kk_status == 'rejected')
                                        Tidak Sesuai
                                    @elseif($document && $document->kk_status == 'pending')
                                        Menunggu Konfirmasi
                                    @else
                                        Silahkan Upload Dokumen
                                    @endif
                                </span>
                            </label>
                            <div class="col-md-12">
                                <input type="file" class="form-control" id="kk" name="kk" 
                                    @if($document && in_array($document->kk_status, ['confirmed', 'pending'])) disabled @endif
                                    onchange="checkFileSize(this)">
                                <small class="text-muted">Ukuran maksimum 1MB (format: pdf)</small>
                                @if($document && $document->kk)
                                    <p class="text-muted">Dokumen saat ini: {{ basename($document->kk) }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Ijazah -->
                        <div class="mb-3 row">
                            <label for="ijazah" class="form-label col-md-8">Ijazah Terakhir (Wajib)
                                <span class="badge 
                                    @if($document && $document->ijazah_status == 'confirmed') bg-success
                                    @elseif($document && $document->ijazah_status == 'rejected') bg-danger
                                    @elseif($document && $document->ijazah_status == 'pending') bg-warning
                                    @else bg-secondary @endif">
                                    @if($document && $document->ijazah_status == 'confirmed')
                                        Terverifikasi
                                    @elseif($document && $document->ijazah_status == 'rejected')
                                        Tidak Sesuai
                                    @elseif($document && $document->ijazah_status == 'pending')
                                        Menunggu Konfirmasi
                                    @else
                                        Silahkan Upload Dokumen
                                    @endif
                                </span>
                            </label>
                            <div class="col-md-12">
                                <input type="file" class="form-control" id="ijazah" name="ijazah" 
                                    @if($document && in_array($document->ijazah_status, ['confirmed', 'pending'])) disabled @endif
                                    onchange="checkFileSize(this)">
                                <small class="text-muted">Ukuran maksimum 1MB (format: pdf)</small>
                                @if($document && $document->ijazah)
                                    <p class="text-muted">Dokumen saat ini: {{ basename($document->ijazah) }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- AK1 -->
                        <div class="mb-3 row">
                            <label for="ak1" class="form-label col-md-8">AK1 (Wajib)
                                <span class="badge 
                                    @if($document && $document->ak1_status == 'confirmed') bg-success
                                    @elseif($document && $document->ak1_status == 'rejected') bg-danger
                                    @elseif($document && $document->ak1_status == 'pending') bg-warning
                                    @else bg-secondary @endif">
                                    @if($document && $document->ak1_status == 'confirmed')
                                        Terverifikasi
                                    @elseif($document && $document->ak1_status == 'rejected')
                                        Tidak Sesuai
                                    @elseif($document && $document->ak1_status == 'pending')
                                        Menunggu Konfirmasi
                                    @else
                                        Silahkan Upload Dokumen
                                    @endif
                                </span>
                            </label>
                            <div class="col-md-12">
                                <input type="file" class="form-control" id="ak1" name="ak1" 
                                    @if($document && in_array($document->ak1_status, ['confirmed', 'pending'])) disabled @endif
                                    onchange="checkFileSize(this)">
                                <small class="text-muted">Ukuran maksimum 1MB (format: pdf)</small>
                                @if($document && $document->ak1)
                                    <p class="text-muted">Dokumen saat ini: {{ basename($document->ak1) }}</p>
                                @endif
                            </div>
                            <div class="col-md-12 mt-1">
                                <small class="text-muted">Untuk Mengurus AK1 Perlu Datang Langsung ke MPP Disnaker</small>
                            </div>
                        </div>

                        <!-- Pesan Revisi -->
                        @if($revision && $revision->revisi_message)
                            <div class="alert alert-danger">
                                <strong>Pesan Revisi dari Admin:</strong>
                                <p>{{ $revision->revisi_message }}</p>
                            </div>
                        @else
                            <div class="alert alert-secondary">
                                <strong>Pesan Revisi dari Admin:</strong>
                                <p>Belum ada pesan</p>
                            </div>
                        @endif

                        <!-- Tombol Simpan -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary" id="saveButton">
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
    // Fungsi untuk cek ukuran file
    function checkFileSize(input) {
        const maxSize = 1024 * 1024; // 1MB dalam byte
        const file = input.files[0];

        if (file && file.size > maxSize) {
            alert("Ukuran file melebihi 1MB. Silakan unggah file dengan ukuran lebih kecil.");
            input.value = ''; // Hapus file dari input
        }
    }
</script>
@endsection
