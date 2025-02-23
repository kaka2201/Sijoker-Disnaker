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
            <div class="d-flex align-items-center">
                <img src="{{ $complaint->questioner->profile && $complaint->questioner->profile->foto ? asset('storage/' . $complaint->questioner->profile->foto) : asset('image/default_profile.jpg') }}" 
                     alt="Profile Image" class="profile-image" 
                     style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #013e7e; margin-right: 10px;">
                <div class="pt-3">
                    <p class="mb-0"><strong>{{ optional($complaint->questioner)->name ?? 'Unknown' }}</strong></p>
                    <p class="text-muted small">{{ $complaint->created_at->addHours(7)->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <p><strong>Status:</strong> 
                <span class="badge {{ $complaint->status == 'answered' ? 'bg-success' : 'bg-warning' }}">
                    {{ ucfirst($complaint->status) }}
                </span>
            </p>
            <hr>
            <h5>Pertanyaan:</h5>
            <p>{{ $complaint->details[0]->question }}</p>
            <h5>Jawaban:</h5>
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
                
                    @if ($detail->answer)
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
        <div class="card-footer">
            <a href="{{ route('admin.complaints') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @if($complaint->status == 'not answered' || $complaint->details[$index]->answer == null)
                <button class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#answerModal">
                    <i class="fas fa-reply"></i> Jawab
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
@endsection
