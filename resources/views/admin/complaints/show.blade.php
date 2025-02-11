@extends('layouts.adminapp')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container-fluid px-4 my-5">
    <h2 class="mt-4 mb-3">Detail Pengaduan</h2>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $complaint->title }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Penanya:</strong> {{ $complaint->questioner->name }}</p>
            <p><strong>Dibuat pada:</strong> {{ $complaint->created_at->format('d M Y, H:i') }}</p>
            <p><strong>Status:</strong> 
                <span class="badge {{ $complaint->status == 'answered' ? 'bg-success' : 'bg-warning' }}">
                    {{ ucfirst($complaint->status) }}
                </span>
            </p>
            <hr>
            <h5>Pertanyaan:</h5>
            <p>{{ $complaint->question }}</p>

            @if($complaint->status == 'answered')
                <hr>
                <h5>Jawaban:</h5>
                <p class="text-success">{{ $complaint->answer }}</p>
                <p><strong>Ditanggapi oleh:</strong> {{ $complaint->responsible->name }}</p>
            @else
                <div class="alert alert-warning">
                    Pengaduan ini belum dijawab.
                </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.complaints') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @if($complaint->status == 'not answered')
            <button class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#answerModal">
                <i class="fas fa-reply"></i> Answer
            </button>
            @endif
        </div>
    </div>
</div>

<!-- Modal Answer -->
<div class="modal fade" id="answerModal" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="answerModalLabel">Answer Complaint</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.complaints.answer', $complaint->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="answer" class="form-label">Your Answer</label>
                        <textarea name="answer" id="answer" class="form-control" rows="4" required>{{ old('answer') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Answer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
