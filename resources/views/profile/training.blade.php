@extends('layouts.appuser')

@section('title', 'Pelatihan')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="row justify-content-center">
        <!-- Sidebar -->
        @include('profile.menu')

        <div class="col-md-7">
            <h1 class="mb-4">Pelatihan yang Diikuti</h1>

            @if($registrations->isEmpty())
                <p class="text-center">Anda belum terdaftar di pelatihan mana pun.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Judul Pelatihan</th>
                            <th>Lokasi</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                            <tr>
                                <td>{{ $registration->training->title }}</td>
                                <td>{{ $registration->training->location }}</td>
                                <td>{{ \Carbon\Carbon::parse($registration->training->start_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($registration->training->end_date)->format('d M Y') }}</td>
                                <td>{{ ucfirst($registration->status) }}</td>
                                <td>
                                    <!-- Button untuk mengundurkan diri -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#withdrawModal-{{ $registration->training->id }}">
                                        Mengundurkan Diri
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="withdrawModal-{{ $registration->training->id }}" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="withdrawModalLabel">Alasan Mengundurkan Diri</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('training.withdraw', $registration->training->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="reason">Alasan:</label>
                                                            <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Mengundurkan Diri</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
