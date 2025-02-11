@extends('layouts.appuser')

@section('title', 'Lengkapi Dokumen')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="row justify-content-center">
        <!-- Sidebar -->
        @include('profile.menu')

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
                        
                        @php
                            $documents = [
                                'ktp' => 'KTP',
                                'kk' => 'Kartu Keluarga',
                                'ijazah' => 'Ijazah Terakhir',
                                'ak1' => 'AK1'
                            ];
                        @endphp
                    
                        @foreach($documents as $key => $label)
                            <div class="mb-3 row">
                                <label for="{{ $key }}" class="form-label col-md-8">{{ $label }} (Wajib)
                                    @php $status = $document->{$key . '_status'} ?? 'none'; @endphp
                                    <span class="badge bg-{{ $status == 'confirmed' ? 'success' : ($status == 'rejected' ? 'danger' : ($status == 'pending' ? 'warning' : 'secondary')) }}">
                                        {{ $status == 'confirmed' ? 'Terverifikasi' : ($status == 'rejected' ? 'Tidak Sesuai' : ($status == 'pending' ? 'Menunggu Konfirmasi' : 'Silahkan Upload Dokumen')) }}
                                    </span>
                                </label>
                                <div class="col-md-12">
                                    <input type="file" class="form-control" id="{{ $key }}" name="{{ $key }}"`  
                                        @if(in_array($status, ['confirmed', 'pending'])) disabled @endif onchange="checkFileSize(this)">
                                    <small class="text-muted">Ukuran maksimum 1MB (format: pdf)</small>
                                    @if(!empty($document->{$key}))
                                        <p class="text-muted">Dokumen saat ini: {{ basename($document->{$key}) }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    
                        @if($revision && $revision->revisi_message)
                        <div class="alert alert-warning">
                            <strong>Pesan dari Admin:</strong>
                            <p>{{ $revision->revisi_message }}</p>
                        </div>
                        @else
                            <div class="alert alert-secondary">
                                <strong>Pesan dari Admin:</strong>
                                <p>Belum ada pesan</p>
                            </div>
                        @endif
                    
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
@endsection
@push('scripts')
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
@endpush
