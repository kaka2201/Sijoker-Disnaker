@extends('layouts.appuser')

@section('title', 'Dinas Tenaga Kerja Kota Batu - Daftar Komplain')

@push('styles')
<style>
    .question-card {
        transition: all 0.3s ease-in-out;
    }
    .question-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
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
<div class="container mt-5">
    <div class="row py-5">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <h1 class="h4 fw-bold">Daftar Komplain</h1>
                <button class="btn btn-primary text-white px-4" data-bs-toggle="modal" data-bs-target="#askQuestionModal">Buat Komplain</button>
            </div>

            <!-- Form Pencarian -->
            <form action="{{ route('complaints.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari komplain..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>

            @if($complaints->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-circle"></i> Belum ada komplain yang diajukan.
                </div>
            @else
                <div class="list-group">
                    @foreach($complaints as $complaint)
                    <div class="list-group-item question-card p-3 mb-3 border rounded shadow-sm">
                        <h2 class="h6 mb-1">
                            <a href="{{ route('complaints.show', $complaint->id) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $complaint->title }}
                            </a>
                        </h2>
                        <p>{{ Str::limit($complaint->question, 100) }}</p>
                        <div class="d-flex justify-content-between small text-secondary">
                            <p class="text-muted small mb-2">
                                Ditanyakan oleh 
                                <img src="{{ $complaint->questioner->profile && $complaint->questioner->profile->foto ? asset('storage/' . $complaint->questioner->profile->foto) : asset('image/default_profile.jpg') }}" 
                                     alt="Profile Image" class="profile-image" 
                                     style="width: 20px; height: 20px; border-radius: 50%; border: 1px solid #013e7e;">
                                {{ $complaint->questioner->name }} | {{ $complaint->created_at->diffForHumans() }}
                            </p>
                            <div>
                                <span><i class="fas fa-comment"></i> {{ $complaint->status }}</span> | 
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
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $complaints->links() }}
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="rules-box p-3 bg-light border rounded">
                <h5 class="fw-bold text-primary">Aturan</h5>
                <ul class="small text-secondary ps-3 mb-0">
                    <li>Jaga kesopanan.</li>
                    <li>Komplain harus jelas.</li>
                    <li>Tidak diperbolehkan spam.</li>
                    <li>Ikuti aturan yang berlaku.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Asking Question -->
<div class="modal fade" id="askQuestionModal" tabindex="-1" aria-labelledby="askQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="askQuestionModalLabel">Ask a Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('complaints.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="questionTitle" class="form-label">Question Title</label>
                        <input type="text" name="title" class="form-control" id="questionTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="questionDetails" class="form-label">Details</label>
                        <textarea name="question" class="form-control" id="questionDetails" rows="4" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-white">Submit</button>
                    </div>
                </form>
            </div>
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
