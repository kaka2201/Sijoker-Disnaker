@extends('layouts.appuser')

@section('title', 'Dinas Tenaga Kerja Kota Batu - Detail Complaint')

@push('styles')
    <style>
        .like-btn {
            cursor: pointer;
            color: #888;
            transition: color 0.3s;
        }
        .like-btn.liked {
            color: #e0245e;
        }
    </style>
@endpush
@section('content')
<div class="container mt-5 py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">{{ $complaint->title }}</h3>
        </div>
        <div class="card-body">
            <p class="text-muted">
                Asked by: <strong>{{ optional($complaint->questioner)->name ?? 'Unknown' }}</strong> |
                <span class="badge bg-{{ $complaint->status == 'answered' ? 'success' : 'warning' }}">
                    {{ ucfirst($complaint->status) }}
                </span>
            </p>
            <p class="mt-3">{{ $complaint->question }}</p>
            
            <div class="mt-4">
                <h5 class="fw-bold">Answer:</h5>
                @if($complaint->answer)
                    <p>{{ $complaint->answer }}</p>
                    <p class="text-muted">Answered by: <strong>{{ ucfirst(optional($complaint->responsible)->name ?? 'Unknown') }} ({{ ucfirst($complaint->responsible->roles->first()->name) }})</strong></p>
                @else
                    <p class="text-danger">This complaint has not been answered yet.</p>
                @endif
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <div>
                    <span class="fw-bold">
                        @auth
                        <i class="fas fa-thumbs-up like-btn {{ auth()->user()->hasLiked($complaint) ? 'liked' : '' }}" 
                           data-id="{{ $complaint->id }}"></i> 
                        <span id="like-count-{{ $complaint->id }}">{{ $complaint->likes_count }}</span> Suka
                        @endauth
                        @guest
                        <i class="fas fa-thumbs-up like-btn" 
                           data-id="{{ $complaint->id }}"></i> 
                        <span id="like-count-{{ $complaint->id }}">{{ $complaint->likes_count }}</span> Suka
                        @endguest
                    </span>
                </div>
                @auth
                @if((auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin')) && $complaint->status == 'not answered')
                    <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#answerModal">
                        <i class="fas fa-reply"></i> Answer
                    </button>
                @endif
                @endauth
            </div>
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            @auth
                let complaintId = this.dataset.id;
                let likeCount = document.getElementById(`like-count-${complaintId}`);
                let isLiked = this.classList.contains('liked');

                fetch(`/complaints/${complaintId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ like: !isLiked })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.classList.toggle('liked');
                        likeCount.textContent = data.likes_count;
                    }
                })
                .catch(error => console.error('Error:', error));
            @else
                // Redirect guest to login page
                window.location.href = "{{ route('login') }}";
            @endauth
        });
    });
</script>
@endpush