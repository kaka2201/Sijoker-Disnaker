@extends('layouts.adminapp')

@section('title', 'Manajemen Peserta')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-users"></i> Manajemen Peserta</h4>
            <form action="{{ route('admin.participant.export') }}" method="GET">
                <input type="hidden" name="universal_search" value="{{ request('search') }}">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-file-csv"></i> Export CSV
                </button>
            </form>
        </div>
        <div class="card-body">
            {{-- <form action="{{ route('admin.participant.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form> --}}

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>NIK</th>
                            <th>TTL</th>
                            <th>Gender</th>
                            <th>Alamat</th>
                            <th>Pendidikan</th>
                            <th>No. Telepon</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($participants as $participant)
                        <tr>
                            <td>{{ $participant->profile->name ?? 'N/A' }}</td>
                            <td>{{ $participant->email }}</td>
                            <td class="text-center">
                                @if(isset($participant->profile->nik))
                                    {{ substr($participant->profile->nik, 0, 5) . str_repeat('*', max(0, strlen($participant->profile->nik) - 5)) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $participant->profile->ttl ?? 'N/A' }}</td>
                            <td class="text-center">{{ $participant->profile->gender ?? 'N/A' }}</td>
                            <td>{{ $participant->profile->desa ?? 'N/A' }}</td>
                            <td class="text-center">{{ $participant->profile->pendidikan ?? 'N/A' }}</td>
                            <td class="text-center">{{ $participant->profile->nomor ?? 'N/A' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.participant.show', $participant->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada peserta ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $participants->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
