<!-- resources/views/admin/withdrawals.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar Pengunduran Diri</h1>

    @if($withdrawalRequests->isEmpty())
        <p>Tidak ada permintaan pengunduran diri.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Pelatihan</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdrawalRequests as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->training->title }}</td>
                        <td>{{ $request->reason }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                        <td>
                            <form action="{{ route('admin.withdrawals.verify', $request->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success">Verifikasi</button>
                            </form>
                            <form action="{{ route('admin.withdrawals.reject', $request->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
