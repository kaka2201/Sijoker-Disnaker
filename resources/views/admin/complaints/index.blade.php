@extends('layouts.adminapp')

@section('title', 'Daftar Pengaduan')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-comments"></i> Daftar Pengaduan</h4>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Penanya</th>
                            <th>Status</th>
                            <th>Likes</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $complaint)
                            {{-- @if ($user->hasRole('user')) --}}
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $complaint->title }}</td>
                                <td>{{ $complaint->questioner->name }}</td>
                                <td>
                                    <span class="badge {{ $complaint->status == 'answered' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($complaint->status) }}
                                    </span>
                                </td>
                                <td>{{ $complaint->likes }}</td>
                                <td>
                                    <a href="{{ route('admin.complaints.show', ['id' => $complaint->id, 'layout' => 'admin']) }}" class="btn text-white btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    {{-- <a href="{{ route('admin.complaints.edit', $complaint->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a> --}}
                                    <form action="{{ route('admin.complaints.destroy', $complaint->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            {{-- @endif --}}
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada complaint ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $complaints->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
