@extends('layouts.adminapp')

@section('title', 'Alasan Penghapusan Peserta')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Menghapus Peserta: {{ $user->name }}</h1>

    <form action="{{ route('admin.removeParticipant', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="reason">Alasan Penghapusan:</label>
            <textarea class="form-control" name="reason" id="reason" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-danger mt-3">Hapus Peserta</button>
    </form>
</div>
@endsection
