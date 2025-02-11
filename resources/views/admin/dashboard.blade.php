@extends('layouts.adminapp')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row g-4">
        <!-- Welcome Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-primary text-white h-100 shadow-lg border-0">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h4 class="card-title mb-3">Selamat Datang, {{ Auth::user()->name }} 🎉</h4>
                        <p class="card-text" id="real-time-clock"></p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-light btn-sm">View Profile</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="col-md-6 col-lg-8">
            <div class="row g-4">
                <div class="col-sm-4">
                    <div class="card bg-info text-white h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x mb-2"></i>
                            <h5 class="card-title">Peserta Aktif</h5>
                            <h2 class="display-4 fw-bold">{{ $pencakerCount }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card bg-success text-white h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-book-open fa-3x mb-2"></i>
                            <h5 class="card-title">Pelatihan</h5>
                            <h2 class="display-4 fw-bold">{{ $trainingCount }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card bg-warning text-dark h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt fa-3x mb-2"></i>
                            <h5 class="card-title">Desa Terbanyak</h5>
                            @if($desaTertinggi)
                                <h2 class="fw-bold mb-1">{{ $desaTertinggi->desa ? $desaTertinggi->desa : 'Unknown' }}</h2>
                                <p class="h4 mb-0">{{ $desaTertinggi->total_peserta }} Peserta</p>
                            @else
                                <h2 class="fw-bold mb-1">Tidak Ada Data</h2>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Peserta -->
        <div class="col-12 mt-4">
            <div class="card shadow border-0">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Jumlah Peserta Per Desa dan Kecamatan</h5>
                    <i class="fas fa-chart-bar fa-lg text-primary"></i>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Jumlah Peserta Per Desa</h6>
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Desa</th>
                                        <th>Jumlah Peserta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($desaData as $desa)
                                        <tr>
                                            <td>{{ $desa->desa ? $desa->desa : 'Unknown' }}</td>
                                            <td>{{ $desa->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-success">Jumlah Peserta Per Kecamatan</h6>
                            <table class="table table-bordered table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th>Jumlah Peserta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kecamatanData as $kecamatan)
                                        <tr>
                                            <td>{{ $kecamatan->kecamatan ? $kecamatan->kecamatan : 'Unknown' }}</td>
                                            <td>{{ $kecamatan->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peserta Per Pelatihan -->
        <div class="col-12 mt-4">
            <div class="card shadow border-0">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Jumlah Peserta Per Pelatihan</h5>
                    <i class="fas fa-graduation-cap fa-lg text-info"></i>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-info">
                            <tr>
                                <th>Pelatihan</th>
                                <th>Jumlah Peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($trainingParticipants as $training)
                            <tr>
                                <td>{{ $training->title }}</td>
                                <td>{{ $training->total_peserta }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Belum ada peserta yang terdaftar.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function updateClock() {
        var now = new Date();
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
        var timeString = now.toLocaleDateString('id-ID', options);
        $('#real-time-clock').text(timeString);
    }

    setInterval(updateClock, 1000);
    $(document).ready(updateClock);
</script>
@endpush
