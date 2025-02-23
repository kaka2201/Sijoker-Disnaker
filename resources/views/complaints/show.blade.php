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
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">{{ $complaint->title }}</h3>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center">
                <img src="{{ $complaint->questioner->profile && $complaint->questioner->profile->foto ? asset('storage/' . $complaint->questioner->profile->foto) : asset('image/default_profile.jpg') }}" 
                         alt="Profile Image" class="profile-image mr-2" 
                         style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #013e7e;">
                <div class="pt-3">
                    <p class="mb-0"><strong>{{ optional($complaint->questioner)->name ?? 'Unknown' }}</strong></p>
                    <p class="text-muted small">{{ $complaint->created_at->addHours(7)->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <div class="p-3 bg-light rounded">
                <p class="mb-0">{{ $complaint->details[0]->question }}</p>
            </div>

            <div class="mt-4">
                <h5 class="fw-bold">Answer:</h5>
                @if($complaint->details[0]->answer)
                    <div class="p-3 bg-white border rounded">
                        <div class="d-flex align-items-center">
                            <img src="{{ $complaint->responsible->profile && $complaint->responsible->profile->foto ? asset('storage/' . $complaint->responsible->profile->foto) : asset('image/default_profile.jpg') }}" 
                                     alt="Profile Image" class="profile-image mr-2" 
                                     style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #013e7e;">
                            <div class="pt-3">
                                <p class="mb-0"><strong>{{ optional($complaint->responsible)->name ?? 'Unknown' }}</strong></p>
                                <p class="text-muted small">{{ $complaint->details[0]->updated_at->addHours(7)->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <p>{{ $complaint->details[0]->answer }}</p>
                    </div>
                @else
                    <div class="alert alert-warning">
                        Pengaduan ini belum dijawab.
                    </div>
                @endif
                @foreach($complaint->details as $index => $detail)
                @if($index > 0)
                    <div class="p-3 bg-white border rounded">
                        <div class="d-flex align-items-center">
                            <img src="{{ $complaint->questioner->profile && $complaint->questioner->profile->foto ? asset('storage/' . $complaint->questioner->profile->foto) : asset('image/default_profile.jpg') }}" 
                                 alt="Profile Image" class="profile-image mr-2" 
                                 style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #013e7e;">
                            <div class="pt-3">
                                <p class="mb-0"><strong>{{ optional($complaint->questioner)->name ?? 'Unknown' }}</strong></p>
                                <p class="text-muted small">{{ $detail->created_at->addHours(7)->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <p>{{ $detail->question }}</p>
                    </div>
                
                    @if($detail->answer)
                        <div class="p-3 bg-white border rounded">
                            <div class="d-flex align-items-center">
                                <img src="{{ $complaint->responsible->profile && $complaint->responsible->profile->foto ? asset('storage/' . $complaint->responsible->profile->foto) : asset('image/default_profile.jpg') }}" 
                                     alt="Profile Image" class="profile-image mr-2" 
                                     style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #013e7e;">
                                <div class="pt-3">
                                    <p class="mb-0"><strong>{{ optional($complaint->responsible)->name ?? 'Unknown' }}</strong></p>
                                    <p class="text-muted small">{{ $detail->updated_at->addHours(7)->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <p>{{ $detail->answer }}</p>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Pengaduan ini belum dijawab.
                        </div>
                    @endif
                    @endif
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div>
                    @auth
                    <i class="fas fa-thumbs-up like-btn {{ auth()->user()->hasLiked($complaint) ? 'liked' : '' }}" 
                       data-id="{{ $complaint->id }}"></i> 
                    <span id="like-count-{{ $complaint->id }}">{{ $complaint->likes_count }}</span> Likes
                    @endauth
                    @guest
                    <i class="fas fa-thumbs-up like-btn" data-id="{{ $complaint->id }}"></i> 
                    <span id="like-count-{{ $complaint->id }}">{{ $complaint->likes_count }}</span> Likes
                    @endguest
                </div>
                @auth
                @if((auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin')) && $complaint->details[$index]->answer == null)
                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#answerModal">
                    <i class="fas fa-reply"></i> Jawab
                </button>
                @elseif(auth()->user()->hasRole('user') && ($complaint->details[$index]->question == null  || $complaint->details[$index]->answer != null))
                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#questionModal">
                    <i class="fas fa-reply"></i> Tanya
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
                <h5 class="modal-title" id="answerModalLabel">Jawab Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.complaints.answer', $complaint->details[$index]->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="answer" class="form-label">Jawabanmu</label>
                        <textarea name="answer" id="answer" class="form-control" rows="4" required>{{ old('answer') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Jawaban</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="questionModalLabel">Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('complaints.ask', $complaint->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Pertanyaan Kamu</label>
                        <textarea name="question" id="question" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Pertanyaan</button>
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