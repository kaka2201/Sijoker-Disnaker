@extends('layouts.adminapp')

@section('title', 'Detail Peserta')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
                <div class="card-header bg-light p-4">
                    <h2 class="mb-0 text-dark">Detail Peserta</h2>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-4 bg-light text-center">
                            <div class="p-5">
                                <img src="{{ Auth::user()->profile && Auth::user()->profile->foto ? asset('storage/' . Auth::user()->profile->foto) : asset('image/default_profile.jpg') }}" alt="Foto Profil" class="img-fluid rounded-circle mb-4" style="border: 3px solid #013e7e; width: 180px; height: 180px; object-fit: cover;">
                                <h3 class="text-dark mb-2">{{ $participant->name }}</h3>
                                <p class="text-muted mb-4">{{ $participant->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="p-5">
                                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active text-dark" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Informasi Pribadi</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link text-dark" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Dokumen</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link text-dark" id="training-tab" data-bs-toggle="tab" data-bs-target="#training" type="button" role="tab" aria-controls="training" aria-selected="false">Pelatihan Terdaftar</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-dark">Data Diri</h5>
                                                <p><strong>NIK:</strong> {{ $participant->nik ?? 'N/A' }}</p>
                                                <p><strong>Tanggal Lahir:</strong> {{ $participant->ttl ?? 'N/A' }}</p>
                                                <p><strong>Gender:</strong> {{ $participant->gender ?? 'N/A' }}</p>
                                                <p><strong>Pendidikan:</strong> {{ $participant->pendidikan ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-dark">Kontak</h5>
                                                <p><strong>Alamat:</strong> {{ $participant->jalan ?? 'N/A' }}, {{ $participant->desa ?? 'N/A' }}, {{ $participant->kecamatan ?? 'N/A' }}</p>
                                                <p><strong>No. Telepon:</strong> {{ $participant->nomor ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bagian untuk Dokumen -->
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            @foreach(['ktp' => 'KTP', 'kk' => 'Kartu Keluarga', 'ijazah' => 'Ijazah Terakhir', 'ak1' => 'AK1'] as $docType => $docName)
                                            <div class="col-md-6 mb-4">
                                                <div class="card border-0 shadow-sm h-100">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $docName }}</h5>
                                                        @if($documents && $documents->$docType)
                                                            <p class="card-text text-muted">Dokumen telah diunggah.</p>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $docType }}Modal">
                                                                <i class="fas fa-eye me-2"></i>Lihat Dokumen
                                                            </button>
                                                        @else
                                                            <p class="card-text text-muted">Dokumen belum diunggah.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            @if($documents && $documents->$docType)
                                            <div class="modal fade" id="{{ $docType }}Modal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $docName }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0">
                                                            <iframe src="{{ route('admin.participant.view.document', ['category' => $docType, 'userId' => $participant->user_id]) }}" width="100%" height="600px" class="border-0">
                                                                <p>Dokumen tidak dapat ditampilkan. <a href="{{ route('admin.participant.view.document', ['category' => $docType, 'userId' => $participant->user_id]) }}" target="_blank">Download</a> dokumen.</p>
                                                            </iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('admin.participant.document.confirm', ['id' => $documents->id, 'type' => $docType]) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success btn-sm">
                                                                    <i class="fas fa-check me-2"></i>Verifikasi
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.participant.document.reject', ['id' => $documents->id, 'type' => $docType]) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-times me-2"></i>Tolak
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>

                                        <!-- Form untuk Kirim Pesan Revisi -->
                                        <div class="mt-4">
                                            <form action="{{ route('admin.participant.sendRevision', $participant->user_id) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="revisiMessage" class="form-label">Pesan Revisi</label>
                                                    <textarea class="form-control" id="revisiMessage" name="revisi_message" rows="3" required>{{ $revisi->revisi_message }}</textarea>
                                                </div>
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-edit"></i> Kirim Revisi
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="training" role="tabpanel" aria-labelledby="training-tab">
                                        <div class="row">
                                            @if($registrations->isEmpty())
                                                <p class="text-muted">Belum terdaftar di pelatihan apapun.</p>
                                            @else
                                                <ul class="list-group">
                                                    @foreach($registrations as $index => $registration)
                                                        <li class="list-group-item">
                                                            <strong>Pelatihan {{ $loop->iteration }}:</strong>
                                                            <br>{{ $registration->training->title }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Kembali dan Hapus -->
                <div class="card-footer bg-light p-4 d-flex justify-content-between">
                    <button class="btn btn-outline-secondary" onclick="window.history.back()">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                    <a href="{{ route('admin.participant.confirmDelete', $participant->user_id) }}" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Hapus Peserta
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setDeleteMessage() {
    var message = document.getElementById('deleteMessage').value;
    document.getElementById('hiddenDeleteMessage').value = message;
}
</script>

@push('styles')
<style>
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    .nav-tabs .nav-link {
        color: #6c757d;
    }
    .nav-tabs .nav-link.active {
        color: #343a40;
        font-weight: bold;
    }
    .modal-header {
        background-color: #007bff;
        color: white;
    }
</style>
@endpush

@endsection
