@extends('admin.layouts.app')

@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistik Berita & Pengumuman -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box border shadow-sm">
            <span class="info-box-icon text-bg-primary shadow-sm"><i class="bi bi-newspaper"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Berita & Regulasi</span>
                <span class="info-box-number">{{ $newsCount }}</span>
            </div>
        </div>
    </div>
    <!-- Statistik Galeri Album -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box border shadow-sm">
            <span class="info-box-icon text-bg-success shadow-sm"><i class="bi bi-images"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Album Galeri</span>
                <span class="info-box-number">{{ $totalAlbums }}</span>
            </div>
        </div>
    </div>
    <!-- Statistik Layanan -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box border shadow-sm">
            <span class="info-box-icon text-bg-info shadow-sm"><i class="bi bi-briefcase-fill"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Persyaratan Layanan</span>
                <span class="info-box-number">{{ $totalServices }}</span>
            </div>
        </div>
    </div>
    <!-- Statistik Pegawai ASN -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box border shadow-sm">
            <span class="info-box-icon text-bg-warning shadow-sm"><i class="bi bi-people-fill"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Statistik Pegawai ASN</span>
                <span class="info-box-number">{{ $totalEmployees }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Statistik Berita & Galeri Detail -->
    <div class="col-md-6 mb-4">
        <div class="card border shadow-sm h-100">
            <div class="card-header border-bottom-0 bg-transparent">
                <h3 class="card-title fw-bold text-success"><i class="bi bi-newspaper me-2"></i>Statistik Berita & Galeri</h3>
            </div>
            <div class="card-body">
                <div class="row text-center mb-3">
                    <div class="col-6 border-end">
                        <h4 class="fw-bold mb-0 text-primary">{{ $activeNews }}</h4>
                        <small class="text-muted">Berita Aktif</small>
                    </div>
                    <div class="col-6">
                        <h4 class="fw-bold mb-0 text-secondary">{{ $draftNews }}</h4>
                        <small class="text-muted">Berita Draft</small>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Total Pembaca Berita</span>
                    <span class="badge bg-info-subtle text-info fw-bold">{{ number_format($totalNewsViews) }} Views</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Total Foto Terunggah</span>
                    <span class="badge bg-success-subtle text-success fw-bold">{{ $totalPhotos }} Foto</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Total Pengumuman</span>
                    <span class="badge bg-warning-subtle text-warning-emphasis fw-bold">{{ $announcementsCount }} Pengumuman</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Persyaratan Layanan & Dasar Hukum -->
    <div class="col-md-6 mb-4">
        <div class="card border shadow-sm h-100">
            <div class="card-header border-bottom-0 bg-transparent">
                <h3 class="card-title fw-bold text-success"><i class="bi bi-journal-check me-2"></i>Persyaratan Layanan & Regulasi</h3>
            </div>
            <div class="card-body">
                <div class="row text-center mb-3">
                    <div class="col-6 border-end">
                        <h4 class="fw-bold mb-0 text-success">{{ $mainServices }}</h4>
                        <small class="text-muted">Layanan Utama</small>
                    </div>
                    <div class="col-6">
                        <h4 class="fw-bold mb-0 text-info">{{ $subServices }}</h4>
                        <small class="text-muted">Sub-Layanan</small>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Layanan dengan Dasar Hukum</span>
                    <span class="badge bg-success fw-bold">{{ $servicesWithRegulation }} Layanan</span>
                </div>
                <div class="progress mb-2" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalServices > 0 ? ($servicesWithRegulation / $totalServices) * 100 : 0 }}%"></div>
                </div>
                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.85rem;">
                    <span>Kelengkapan Dasar Hukum</span>
                    <span>{{ $totalServices > 0 ? round(($servicesWithRegulation / $totalServices) * 100) : 0 }}% Terisi</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Statistik Pegawai Saat Ini -->
    <div class="col-md-6 mb-4">
        <div class="card border shadow-sm h-100">
            <div class="card-header border-bottom-0 bg-transparent">
                <h3 class="card-title fw-bold text-success"><i class="bi bi-people-fill me-2"></i>Statistik Kepegawaian ASN</h3>
            </div>
            <div class="card-body">
                @if($totalEmployees > 0)
                    <div class="row align-items-center">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <canvas id="employeeGenderChart" style="max-height: 180px;"></canvas>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="bi bi-circle-fill text-primary me-2"></i>PNS</span>
                                <span class="fw-bold">{{ $totalPns }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="bi bi-circle-fill text-info me-2"></i>CPNS</span>
                                <span class="fw-bold">{{ $totalCpns }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="bi bi-circle-fill text-success me-2"></i>PPPK</span>
                                <span class="fw-bold">{{ $totalPppk }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-circle-fill text-warning me-2"></i>PPPK Paruh Waktu</span>
                                <span class="fw-bold">{{ $totalPppkParuhWaktu }}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center mt-2">
                        <div class="col-6 border-end">
                            <span class="text-muted d-block mb-1"><i class="bi bi-gender-male text-primary"></i> Laki-laki</span>
                            <h5 class="fw-bold mb-0">{{ $employeesMale }}</h5>
                        </div>
                        <div class="col-6">
                            <span class="text-muted d-block mb-1"><i class="bi bi-gender-female text-danger"></i> Perempuan</span>
                            <h5 class="fw-bold mb-0">{{ $employeesFemale }}</h5>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="text-muted mb-3"><i class="bi bi-database-fill-exclamation" style="font-size: 3rem; color: #adb5bd;"></i></div>
                        <h6 class="fw-bold">Belum Ada Data Pegawai</h6>
                        <p class="text-muted small px-3 mb-0">Silakan import data pegawai ASN saat ini melalui menu **Statistik Pegawai** di dashboard admin untuk melihat visualisasi data kependudukan secara detail.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistik Struktur Organisasi -->
    <div class="col-md-6 mb-4">
        <div class="card border shadow-sm h-100">
            <div class="card-header border-bottom-0 bg-transparent">
                <h3 class="card-title fw-bold text-success"><i class="bi bi-diagram-3-fill me-2"></i>Statistik Struktur Organisasi</h3>
            </div>
            <div class="card-body">
                <div class="row text-center mb-3">
                    <div class="col-4 border-end">
                        <h4 class="fw-bold mb-0 text-success">{{ $totalStructures }}</h4>
                        <small class="text-muted">Total Jabatan</small>
                    </div>
                    <div class="col-4 border-end">
                        <h4 class="fw-bold mb-0 text-primary">{{ $mainStructures }}</h4>
                        <small class="text-muted">Unit Utama</small>
                    </div>
                    <div class="col-4">
                        <h4 class="fw-bold mb-0 text-info">{{ $subStructures }}</h4>
                        <small class="text-muted">Jabatan Staf</small>
                    </div>
                </div>
                <hr>
                <h6 class="fw-bold mb-2">Sebaran Eselon Terdaftar:</h6>
                <div style="max-height: 150px; overflow-y: auto;">
                    <ul class="list-group list-group-flush">
                        @forelse($echelonStats as $eselon)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-muted">Eselon {{ $eselon->echelon }}</span>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis fw-bold">{{ $eselon->total }} Posisi</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted px-0">Belum ada sebaran eselon terinput.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Grafik Pengunjung -->
    <div class="col-lg-8 mb-4">
        <div class="card border shadow-sm h-100">
            <div class="card-header border-bottom-0 bg-transparent">
                <h3 class="card-title fw-bold text-success"><i class="bi bi-graph-up-arrow me-2"></i>Statistik Pengunjung (7 Hari Terakhir)</h3>
            </div>
            <div class="card-body">
                <canvas id="visitorChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <!-- Aktivitas Terbaru -->
    <div class="col-lg-4 mb-4">
        <div class="card border shadow-sm h-100">
            <div class="card-header border-bottom-0 bg-transparent">
                <h3 class="card-title fw-bold text-success"><i class="bi bi-activity me-2"></i>Log Aktivitas Terbaru</h3>
            </div>
            <div class="card-body p-0" style="max-height: 282px; overflow-y: auto;">
                <ul class="list-group list-group-flush">
                    @forelse($activityLogs as $log)
                        <li class="list-group-item d-flex justify-content-between align-items-start py-2">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold" style="font-size: 0.95rem;">{{ $log->user->name ?? 'Unknown' }}</div>
                                <small class="text-muted"><i class="bi bi-box-arrow-in-right me-1"></i>{{ $log->action }} from {{ $log->ip_address }}</small>
                            </div>
                            <span class="badge bg-secondary rounded-pill" style="font-size: 0.75rem;">{{ $log->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Belum ada aktivitas.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Peta Sebaran Pegawai ASN Berdasarkan Provinsi (Admin Leaflet Map) -->
<div class="row mt-4 mb-4">
    <div class="col-12">
        <div class="card border shadow-sm">
            <div class="card-header border-bottom-0 bg-transparent d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="card-title fw-bold text-success mb-0">
                    <i class="bi bi-geo-alt-fill me-2"></i>Peta Sebaran Jumlah Pegawai Berdasarkan Provinsi
                </h3>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fw-semibold rounded-pill mt-2 mt-sm-0">
                    <i class="bi bi-map me-1"></i>Peta Interaktif (Leaflet JS)
                </span>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div id="adminProvMap" style="height: 480px; width: 100%; border-radius: 12px; border: 1px solid #dee2e6; z-index: 1;"></div>
                    </div>
                    <div class="col-lg-4">
                        <div class="p-3 bg-body-tertiary rounded-3 border h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-dark m-0"><i class="bi bi-geo-alt-fill text-success me-2"></i>Sebaran Pegawai Seluruh Provinsi</h6>
                                <span class="badge bg-success-subtle text-success border">38 Provinsi</span>
                            </div>
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-hover table-striped table-sm mb-0" style="font-size: 0.88rem;">
                                    <thead class="table-dark sticky-top">
                                        <tr>
                                            <th>#</th>
                                            <th>Provinsi</th>
                                            <th class="text-end">Jumlah</th>
                                            <th class="text-center">Satker</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($provinceStats as $idx => $p)
                                        <tr onclick="focusProvinceOnMapAdmin('{{ $p['province'] }}', {{ $p['lat'] }}, {{ $p['lng'] }})" style="cursor: pointer;" title="Klik untuk fokus lokasi {{ $p['province'] }} pada peta">
                                            <td>{{ $idx + 1 }}</td>
                                            <td class="fw-medium">
                                                <i class="bi bi-geo-alt-fill text-success me-1"></i>{{ $p['province'] }}
                                            </td>
                                            <td class="text-end fw-bold text-success">{{ number_format($p['total']) }}</td>
                                            <td class="text-center" onclick="event.stopPropagation();">
                                                <button type="button" class="btn btn-xs btn-outline-success py-0 px-2 rounded-pill" onclick="openSatkerModalAdmin({{ json_encode($p) }})" style="font-size:0.75rem;">
                                                    Satker
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Sebaran Data Pegawai per Pulau & Rincian Provinsi (Admin) -->
                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        <div>
                            <h5 class="fw-bold text-dark mb-1"><i class="bi bi-globe-asia-australia text-success me-2"></i>Sebaran Data Pegawai ASN Berdasarkan Pulau & Rincian Provinsi</h5>
                            <small class="text-muted">Persebaran pegawai ASN pada 7 wilayah utama beserta rincian tiap provinsi</small>
                        </div>
                        <span class="badge bg-success rounded-pill px-3 py-2">7 Gugus Pulau</span>
                    </div>

                    <!-- Ringkasan 7 Gugus Pulau -->
                    <div class="table-responsive border rounded-3 mb-4">
                        <table class="table table-hover table-striped mb-0 align-middle" style="font-size: 0.88rem;">
                            <thead class="table-success text-dark fw-bold">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Wilayah / Pulau</th>
                                    <th class="text-center">Jumlah Provinsi</th>
                                    <th class="text-end">PNS</th>
                                    <th class="text-end">CPNS</th>
                                    <th class="text-end">PPPK</th>
                                    <th class="text-end">PPPK Paruh Waktu</th>
                                    <th class="text-end pe-3">Total ASN</th>
                                    <th class="text-end pe-3">% Dari Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotalAdminIsland = array_sum(array_column($islandStats, 'total')); @endphp
                                @foreach($islandStats as $index => $pulau)
                                <tr>
                                    <td class="ps-3 fw-bold text-secondary">{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark"><i class="bi bi-geo-fill text-success me-1"></i>{{ $pulau['island'] }}</td>
                                    <td class="text-center"><span class="badge bg-light text-dark border">{{ $pulau['provinces_count'] }} Provinsi</span></td>
                                    <td class="text-end fw-semibold text-primary">{{ number_format($pulau['pns']) }}</td>
                                    <td class="text-end fw-semibold text-info">{{ number_format($pulau['cpns']) }}</td>
                                    <td class="text-end fw-semibold text-success">{{ number_format($pulau['pppk']) }}</td>
                                    <td class="text-end fw-semibold text-warning">{{ number_format($pulau['pppk_paruh_waktu']) }}</td>
                                    <td class="text-end pe-3 fw-bold text-dark">{{ number_format($pulau['total']) }}</td>
                                    <td class="text-end pe-3 fw-bold text-success">{{ $grandTotalAdminIsland > 0 ? number_format(($pulau['total'] / $grandTotalAdminIsland) * 100, 1) : 0 }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Rincian Provinsi per Gugus Pulau -->
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-list-nested text-success me-2"></i>Rincian Provinsi di Setiap Gugus Pulau</h6>
                    <div class="row g-4">
                        @foreach($islandStats as $pulau)
                        <div class="col-lg-6">
                            <div class="card border shadow-sm rounded-3 h-100">
                                <div class="card-header bg-success text-white py-2 px-3 d-flex justify-content-between align-items-center">
                                    <span class="fw-bold"><i class="bi bi-map me-2"></i>Wilayah {{ $pulau['island'] }}</span>
                                    <span class="badge bg-white text-success fw-bold">{{ number_format($pulau['total']) }} Pegawai</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="max-height: 280px; overflow-y: auto;">
                                        <table class="table table-hover table-striped table-sm mb-0 align-middle" style="font-size: 0.84rem;">
                                            <thead class="table-light sticky-top">
                                                <tr>
                                                    <th class="ps-3">Provinsi</th>
                                                    <th class="text-end">PNS</th>
                                                    <th class="text-end">CPNS</th>
                                                    <th class="text-end">PPPK</th>
                                                    <th class="text-end">Total</th>
                                                    <th class="text-center pe-3">Satker</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pulau['provinces_detail'] as $pDetail)
                                                <tr onclick="focusProvinceOnMapAdmin('{{ $pDetail['province'] }}', {{ $pDetail['lat'] }}, {{ $pDetail['lng'] }})" style="cursor: pointer;" title="Klik untuk fokus lokasi {{ $pDetail['province'] }} pada peta">
                                                    <td class="ps-3 fw-semibold text-dark">
                                                        <i class="bi bi-geo-alt-fill text-success me-1"></i>{{ $pDetail['province'] }}
                                                    </td>
                                                    <td class="text-end text-primary">{{ number_format($pDetail['pns']) }}</td>
                                                    <td class="text-end text-info">{{ number_format($pDetail['cpns']) }}</td>
                                                    <td class="text-end text-success">{{ number_format($pDetail['pppk']) }}</td>
                                                    <td class="text-end fw-bold text-dark">{{ number_format($pDetail['total']) }}</td>
                                                    <td class="text-center pe-3" onclick="event.stopPropagation();">
                                                        <button type="button" class="btn btn-xs btn-outline-success py-0 px-2 rounded-pill" onclick="openSatkerModalAdmin({{ json_encode($pDetail) }})" style="font-size:0.72rem;">
                                                            Satker
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Satker per Provinsi (Admin) -->
<div class="modal fade" id="adminSatkerModal" tabindex="-1" aria-labelledby="adminSatkerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="adminSatkerModalLabel">
                    <i class="bi bi-building me-2"></i>Daftar Satker di Provinsi <span id="adminModalProvName"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div>
                        <span class="badge bg-success-subtle text-success border px-3 py-2 rounded-pill fw-semibold">
                            Total Pegawai: <strong id="adminModalProvTotal">0</strong>
                        </span>
                        <span class="badge bg-secondary-subtle text-secondary border px-3 py-2 rounded-pill fw-semibold ms-2">
                            Total Satker: <strong id="adminModalSatkerCount">0</strong>
                        </span>
                    </div>
                    <div class="w-100 w-sm-auto">
                        <input type="text" id="adminModalSatkerSearch" class="form-control form-control-sm" placeholder="Cari satker..." onkeyup="filterAdminSatkerModalList()">
                    </div>
                </div>
                <div class="table-responsive border rounded-3" style="max-height: 380px;">
                    <table class="table table-hover table-striped mb-0 align-middle" style="font-size: 0.88rem;">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>#</th>
                                <th>Nama Satker / Unit Kerja</th>
                                <th class="text-end">Jumlah Pegawai</th>
                            </tr>
                        </thead>
                        <tbody id="adminModalSatkerTbody">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('dist/leaflet.css') }}" />
@endpush

@push('scripts')
<script src="{{ asset('dist/leaflet.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Visitor Chart
    const ctxVisitor = document.getElementById('visitorChart').getContext('2d');
    const visitorChart = new Chart(ctxVisitor, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Jumlah Pengunjung',
                data: {!! json_encode($chartData['data']) !!},
                backgroundColor: 'rgba(46, 125, 50, 0.5)',
                borderColor: 'rgba(46, 125, 50, 1)',
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

    @if($totalEmployees > 0)
    // Employee Gender Pie/Doughnut Chart
    const ctxGender = document.getElementById('employeeGenderChart').getContext('2d');
    const employeeGenderChart = new Chart(ctxGender, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [{{ $employeesMale }}, {{ $employeesFemale }}],
                backgroundColor: ['#3498db', '#e74c3c'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    @endif

    // Leaflet Map for Admin Dashboard
    const adminProvStats = @json($provinceStats);
    if (document.getElementById('adminProvMap')) {
        const adminMap = L.map('adminProvMap', {
            center: [-2.5489, 118.0149],
            zoom: 5,
            scrollWheelZoom: true
        });

        window.adminLeafletMapObj = adminMap;
        window.adminProvinceMarkersMap = {};

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors | ROSMO Admin'
        }).addTo(adminMap);

        setTimeout(() => {
            adminMap.invalidateSize();
        }, 250);

        adminProvStats.forEach(prov => {
            if (prov.total > 0) {
                const radius = Math.max(8, Math.min(32, Math.sqrt(prov.total) * 1.5));
                
                const circle = L.circleMarker([prov.lat, prov.lng], {
                    radius: radius,
                    color: '#0d3b23',
                    fillColor: '#2e7d32',
                    fillOpacity: 0.75,
                    weight: 2
                }).addTo(adminMap);

                window.adminProvinceMarkersMap[prov.province] = circle;

                let es1Html = '';
                if (prov.eselon1) {
                    const topEs1 = Object.entries(prov.eselon1).sort((a,b) => b[1] - a[1]).slice(0, 3);
                    if (topEs1.length > 0) {
                        es1Html = `<div style="margin-top:6px;"><b>Eselon I Terbanyak:</b><ul style="margin:2px 0 0 0; padding-left:16px; font-size:0.8rem;">` +
                            topEs1.map(e => `<li>${e[0]}: <b>${e[1]}</b></li>`).join('') +
                            `</ul></div>`;
                    }
                }

                let kotaHtml = '';
                if (prov.kota_list && prov.kota_list.length > 0) {
                    const sampleKota = prov.kota_list.slice(0, 3).join(', ');
                    const extraKota = prov.kota_list.length > 3 ? ` (+${prov.kota_list.length - 3} kota/kab)` : '';
                    kotaHtml = `<div style="font-size:0.8rem; color:#64748b; margin-top:2px;"><b>Kedudukan Kota:</b> ${sampleKota}${extraKota}</div>`;
                }

                let satkerHtml = '';
                if (prov.satker) {
                    const topSatker = Object.entries(prov.satker).slice(0, 3);
                    if (topSatker.length > 0) {
                        satkerHtml = `<div style="margin-top:6px;"><b>Satker Terbanyak:</b><ul style="margin:2px 0 0 0; padding-left:16px; font-size:0.8rem;">` +
                            topSatker.map(s => `<li>${s[0]}: <b>${Number(s[1]).toLocaleString()}</b></li>`).join('') +
                            `</ul></div>`;
                    }
                }

                const popupContent = `
                    <div style="font-family: inherit; min-width: 230px; padding: 2px;">
                        <h6 style="margin: 0 0 6px 0; color: #1b5e3a; font-weight: 700; border-bottom: 2px solid #2e7d32; padding-bottom: 4px;">${prov.province}</h6>
                        ${kotaHtml}
                        <div style="font-size: 0.88rem; margin-top:4px;">
                            <b>Total Pegawai:</b> <span style="color: #2e7d32; font-weight: 800; font-size: 1.05rem;">${prov.total.toLocaleString()}</span><br>
                            <hr style="margin: 4px 0;">
                            <b>PNS:</b> ${prov.pns.toLocaleString()} | <b>CPNS:</b> ${prov.cpns.toLocaleString()}<br>
                            <b>PPPK:</b> ${prov.pppk.toLocaleString()}<br>
                            <hr style="margin: 4px 0;">
                            <span style="color: #0d6efd;"><b>Laki-laki:</b> ${prov.male.toLocaleString()}</span> | 
                            <span style="color: #dc3545;"><b>Perempuan:</b> ${prov.female.toLocaleString()}</span>
                            ${es1Html}
                            ${satkerHtml}
                        </div>
                    </div>
                `;

                circle.bindPopup(popupContent);
                circle.bindTooltip(`<b>${prov.province}</b>: ${prov.total.toLocaleString()} Pegawai`, { direction: 'top' });
            }
        });
    }

    // Fly and Focus Province on Admin Interactive Map
    window.focusProvinceOnMapAdmin = function(provName, lat, lng) {
        const mapEl = document.getElementById('adminProvMap');
        if (mapEl) {
            mapEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        if (window.adminLeafletMapObj) {
            window.adminLeafletMapObj.flyTo([lat, lng], 8, {
                animate: true,
                duration: 1.2
            });
        }

        if (window.adminProvinceMarkersMap && window.adminProvinceMarkersMap[provName]) {
            setTimeout(() => {
                window.adminProvinceMarkersMap[provName].openPopup();
            }, 600);
        }
    };

    // Modal Handler for Admin Satker Details per Province
    window.openSatkerModalAdmin = function(provData) {
        document.getElementById('adminModalProvName').innerText = provData.province;
        document.getElementById('adminModalProvTotal').innerText = provData.total.toLocaleString();
        
        const satkerEntries = provData.satker ? Object.entries(provData.satker) : [];
        document.getElementById('adminModalSatkerCount').innerText = satkerEntries.length.toLocaleString();
        document.getElementById('adminModalSatkerSearch').value = '';

        renderAdminSatkerModalTbody(satkerEntries);
        const modal = new bootstrap.Modal(document.getElementById('adminSatkerModal'));
        modal.show();
    };

    window.adminCurrentSatkerEntries = [];

    function renderAdminSatkerModalTbody(entries) {
        window.adminCurrentSatkerEntries = entries;
        const tbody = document.getElementById('adminModalSatkerTbody');
        if (entries.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-3">Tidak ada data satker.</td></tr>';
            return;
        }

        let html = '';
        entries.forEach((e, idx) => {
            html += `<tr>
                <td class="fw-semibold text-secondary">${idx + 1}</td>
                <td class="fw-medium text-dark">${e[0]}</td>
                <td class="text-end fw-bold text-success">${Number(e[1]).toLocaleString()}</td>
            </tr>`;
        });
        tbody.innerHTML = html;
    }

    window.filterAdminSatkerModalList = function() {
        const q = document.getElementById('adminModalSatkerSearch').value.toLowerCase().trim();
        if (!window.adminCurrentSatkerEntries) return;
        
        const filtered = window.adminCurrentSatkerEntries.filter(e => e[0].toLowerCase().includes(q));
        const tbody = document.getElementById('adminModalSatkerTbody');
        
        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-3">Tidak ada satker yang cocok.</td></tr>';
            return;
        }

        let html = '';
        filtered.forEach((e, idx) => {
            html += `<tr>
                <td class="fw-semibold text-secondary">${idx + 1}</td>
                <td class="fw-medium text-dark">${e[0]}</td>
                <td class="text-end fw-bold text-success">${Number(e[1]).toLocaleString()}</td>
            </tr>`;
        });
        tbody.innerHTML = html;
    };

});
</script>
@endpush