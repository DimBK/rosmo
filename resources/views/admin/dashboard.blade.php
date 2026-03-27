@extends('admin.layouts.app')

@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Konten Berita -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box border shadow-sm">
            <span class="info-box-icon text-bg-primary shadow-sm"><i class="bi bi-newspaper"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Berita</span>
                <span class="info-box-number">{{ $newsCount }}</span>
            </div>
        </div>
    </div>
    <!-- Konten Pengumuman -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box border shadow-sm">
            <span class="info-box-icon text-bg-success shadow-sm"><i class="bi bi-megaphone"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Pengumuman</span>
                <span class="info-box-number">{{ $announcementsCount }}</span>
            </div>
        </div>
    </div>
    <!-- Pengunjung Bulan Ini -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box border shadow-sm">
            <span class="info-box-icon text-bg-info shadow-sm"><i class="bi bi-calendar-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pengunjung Bulan Ini</span>
                <span class="info-box-number">{{ $monthlyVisitorsCount }}</span>
            </div>
        </div>
    </div>
    <!-- Pengunjung Hari Ini -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box border shadow-sm">
            <span class="info-box-icon text-bg-warning shadow-sm"><i class="bi bi-people-fill"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pengunjung Hari Ini</span>
                <span class="info-box-number">{{ $todayVisitorsCount }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Grafik -->
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header border-0">
                <h3 class="card-title">Statistik Pengunjung (7 Hari Terakhir)</h3>
            </div>
            <div class="card-body">
                <canvas id="visitorChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <!-- Aktivitas -->
    <div class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header border-0">
                <h3 class="card-title">Log Aktivitas (Login Terbaru)</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($activityLogs as $log)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $log->user->name ?? 'Unknown' }}</div>
                                <small class="text-muted"><i class="bi bi-box-arrow-in-right"></i> Logged in from {{ $log->ip_address }}</small>
                            </div>
                            <span class="badge bg-secondary rounded-pill">{{ $log->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Belum ada aktivitas.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('visitorChart').getContext('2d');
    const visitorChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Jumlah Pengunjung',
                data: {!! json_encode($chartData['data']) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush