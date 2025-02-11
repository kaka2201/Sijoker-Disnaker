@extends('layouts.adminapp')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-users"></i> Manajemen Akun Peserta</h4>
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
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            {{-- @if ($user->hasRole('user')) --}}
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @php
                                        $role = $user->roles->first();
                                    @endphp
                                
                                    <span class="badge {{ $role && ($user->hasRole('admin') || $user->hasRole('super_admin')) ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $role ? ucfirst($role->name) : 'No Role' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.change_role', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn {{ $user->hasRole('user') ? 'btn-outline-success' : 'btn-outline-warning' }}">
                                            {{ $user->hasRole('user') ? 'Jadikan Admin' : 'Jadikan User' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            {{-- @endif --}}
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada peserta akun ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
