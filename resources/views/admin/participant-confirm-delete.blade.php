@extends('layouts.adminapp')

@section('title', 'Konfirmasi Hapus Peserta')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
                <div class="card-header bg-light p-4">
                    <h2 class="mb-0 text-dark">Konfirmasi Hapus Peserta</h2>
                </div>
                <div class="card-body p-4">
                    <p>Anda yakin ingin menghapus peserta <strong>{{ $participant->name }}</strong>?</p>
                    <form action="{{ route('participant.delete', $participant->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan (Opsional)</label>
                            <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus Peserta
                        </button>
                        <a href="{{ route('admin.participant_management') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
