@extends('layouts.adminapp')

@section('title', 'Manajemen Peserta')

@section('content')
    <div class="container">
        <h1>Manajemen Peserta</h1>

        <!-- Search Universal Form -->
        <form id="filterForm" action="{{ route('participant.index') }}" method="GET" class="mb-3">
            <div class="row mb-3">
                <div class="col-md-10">
                    <label for="universal_search" class="form-label">Search Sesuai dengan kolom tabel</label>
                    <div class="input-group">
                        <input type="text" name="universal_search" id="universal_search" class="form-control" placeholder="Cari berdasarkan Nama atau Email" value="{{ request('universal_search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Tombol Export CSV -->
        <form action="{{ route('participant.export') }}" method="GET">
            <!-- Biar tetap kirim parameter filter yang sedang aktif -->
            <input type="hidden" name="universal_search" value="{{ request('universal_search') }}">
            <button type="submit" class="btn btn-success mb-3">
                <i class="fa fa-file-csv"></i> Export CSV
            </button>
        </form>

        <!-- Tabel data peserta -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>NIK</th>
                    <th>TTL</th>
                    <th>Umur</th>
                    <th>Gender</th>
                    <th>Jalan</th>
                    <th>Desa</th>
                    <th>Kecamatan</th>
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
                    <td>
                        @if(isset($participant->profile->nik))
                            {{ substr($participant->profile->nik, 0, 5) . str_repeat('*', max(0, strlen($participant->profile->nik) - 5)) }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $participant->profile->ttl ?? 'N/A' }}</td>
                    <td>
                        @if($participant->profile && $participant->profile->ttl)
                            @php
                                $birthday = new DateTime($participant->profile->ttl);
                                $today = new DateTime();
                                $age = $today->diff($birthday)->y;
                            @endphp
                            {{ $age }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $participant->profile->gender ?? 'N/A' }}</td>
                    <td>{{ $participant->profile->jalan ?? 'N/A' }}</td>
                    <td>{{ $participant->profile->desa ?? 'N/A' }}</td>
                    <td>{{ $participant->profile->kecamatan ?? 'N/A' }}</td>
                    <td>{{ $participant->profile->pendidikan ?? 'N/A' }}</td>
                    <td>{{ $participant->profile->nomor ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('participant.show', $participant->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="text-center">Tidak ada peserta ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
