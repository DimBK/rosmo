@extends('layouts.app')

@section('body_class', 'statistik-page')

@push('styles')
<link rel="stylesheet" href="{{ asset('dist/leaflet.css') }}" />
<style>
    .statistik-hero {
        padding: 130px 0 70px 0;
        background: linear-gradient(135deg, #0d3b23 0%, #1b5e3a 45%, #2e7d32 85%, #388e3c 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }
    .statistik-hero::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
        top: -150px;
        left: -150px;
        pointer-events: none;
    }
    .statistik-hero::after {
        content: '';
        position: absolute;
        width: 350px;
        height: 350px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 50%;
        bottom: -100px;
        right: -100px;
        pointer-events: none;
    }
    .stat-hero-card {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(12px);
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        height: 100%;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(255,255,255,0.4);
    }
    .stat-hero-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 36px rgba(0,0,0,0.18);
    }
    .stat-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        height: 100%;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        box-shadow: 0 16px 36px rgba(0,0,0,0.08);
    }
    .stat-card-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f1f5f9;
    }
    .stat-card-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.12rem;
        margin: 0;
    }
    .stat-value {
        font-size: 2.75rem;
        font-weight: 800;
        color: #1b5e3a;
        line-height: 1.1;
        letter-spacing: -1px;
    }
    .stat-label {
        color: #64748b;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .chart-container {
        position: relative;
        height: 350px;
        width: 100%;
    }
    .period-badge {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 0.9rem;
        backdrop-filter: blur(8px);
    }
    .table-container {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        margin-bottom: 2rem;
    }
    /* Dedicated Scroll Container for Sticky Table Headers */
    .table-scrollable {
        max-height: 520px;
        overflow-y: auto;
        overflow-x: auto;
        position: relative;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        background: #ffffff;
    }
    .table-custom {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        margin-bottom: 0;
    }
    /* Sticky Table Headers for Table 12 & 13 */
    .table-custom thead {
        position: sticky;
        top: 0;
        z-index: 30;
    }
    .table-custom thead th {
        position: sticky;
        top: 0;
        z-index: 30;
        background: #1b5e3a !important;
        color: #ffffff !important;
        text-align: center;
        vertical-align: middle;
        font-weight: 600;
        border-top: none;
        border-bottom: 2px solid #0d3b23 !important;
        border-left: 1px solid rgba(255,255,255,0.1);
        border-right: 1px solid rgba(255,255,255,0.1);
        padding: 12px 16px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.12);
    }
    .table-custom td {
        vertical-align: middle;
        padding: 11px 16px;
        border-color: #f1f5f9;
        font-size: 0.92rem;
    }
    .table-custom tbody tr:hover {
        background-color: #f8fafc;
    }
    .table-custom .total-col {
        font-weight: 700;
        background-color: #f1f5f9;
        color: #1e293b;
    }
    .nav-pills-custom .nav-link {
        color: #475569;
        font-weight: 600;
        font-size: 0.88rem;
        border-radius: 30px;
        padding: 8px 20px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        margin-right: 8px;
        margin-bottom: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }
    .nav-pills-custom .nav-link.active, .nav-pills-custom .nav-link:hover {
        background: linear-gradient(135deg, #1b5e3a, #2e7d32);
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(27, 94, 58, 0.2);
    }
</style>
<link rel="stylesheet" href="{{ asset('dist/leaflet.css') }}" />
@endpush

@section('content')
<main class="main">

    <!-- Hero Section -->
    <section class="statistik-hero">
        <div class="container" data-aos="fade-up">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div class="mb-3 mb-md-0">
                    <h1 class="mb-2 fw-bold" style="letter-spacing: -0.5px;">Dashboard Statistik Kepegawaian</h1>
                    <p class="mb-0 text-white-50 fs-6">Biro Sumber Daya Manusia dan Organisasi - Kementerian Kehutanan RI</p>
                </div>
                <div class="period-badge">
                    <form action="" method="GET" class="d-flex align-items-center m-0">
                        <i class="bi bi-calendar3 me-2 text-white fs-6"></i>
                        <span class="text-white me-2 small fw-semibold">Periode:</span>
                        <select name="periode" class="form-select form-select-sm bg-transparent text-white border-0 shadow-none fw-bold" onchange="this.form.submit()" style="outline:none; width: auto; cursor:pointer;">
                            @if(count($availablePeriods) === 0)
                                <option value="Tahun Ini" class="text-dark">Belum ada data</option>
                            @else
                                <option value="Tahun Ini" {{ $statisticsPeriod === 'Tahun Ini' ? 'selected' : '' }} class="text-dark">Semua Data</option>
                                @foreach($availablePeriods as $ap)
                                    <option value="{{ $ap }}" {{ $statisticsPeriod === $ap ? 'selected' : '' }} class="text-dark">{{ $ap }}</option>
                                @endforeach
                            @endif
                        </select>
                    </form>
                </div>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-hero-card text-center d-flex flex-column justify-content-center">
                        <div class="stat-value text-success" data-purecounter-start="0" data-purecounter-end="{{ $totalAsn }}" data-purecounter-duration="1" class="purecounter">{{ number_format($totalAsn) }}</div>
                        <div class="stat-label mt-2 text-success">TOTAL PEGAWAI ASN</div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-6">
                    <div class="row g-4 h-100">
                        <div class="col-md-3 col-6">
                            <div class="stat-hero-card text-center text-md-start">
                                <div class="stat-value fs-2 text-primary" data-purecounter-start="0" data-purecounter-end="{{ $totalPns }}" data-purecounter-duration="1" class="purecounter">{{ number_format($totalPns) }}</div>
                                <div class="stat-label">PNS</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-hero-card text-center text-md-start">
                                <div class="stat-value fs-2 text-info" data-purecounter-start="0" data-purecounter-end="{{ $totalCpns }}" data-purecounter-duration="1" class="purecounter">{{ number_format($totalCpns) }}</div>
                                <div class="stat-label">CPNS</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-hero-card text-center text-md-start">
                                <div class="stat-value fs-2 text-success" data-purecounter-start="0" data-purecounter-end="{{ $totalPppk }}" data-purecounter-duration="1" class="purecounter">{{ number_format($totalPppk) }}</div>
                                <div class="stat-label">PPPK</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-hero-card text-center text-md-start">
                                <div class="stat-value fs-2 text-warning" data-purecounter-start="0" data-purecounter-end="{{ $totalPppkParuhWaktu }}" data-purecounter-duration="1" class="purecounter">{{ number_format($totalPppkParuhWaktu) }}</div>
                                <div class="stat-label">PPPK PARUH WAKTU</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Charts & Tables Section -->
    <section class="section bg-light pt-4 pb-5">
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <!-- Quick Jump Nav Pills -->
            <div class="mb-4 d-flex flex-wrap nav-pills-custom align-items-center">
                <span class="text-secondary fw-bold me-3 small"><i class="bi bi-compass-fill text-success me-1"></i> Pintasan Navigasi:</span>
                <a href="#section-peta" class="nav-link">Peta Sebaran Provinsi</a>
                <a href="#section-demografi" class="nav-link">Demografi & Lokasi</a>
                <a href="#section-golongan" class="nav-link">Pangkat & Golongan</a>
                <a href="#section-pendidikan" class="nav-link">Pendidikan & Usia</a>
                <a href="#section-eselon" class="nav-link">Eselon & Fungsional</a>
            </div>

            <!-- Peta Sebaran Pegawai berdasarkan Provinsi (Interactive Leaflet Map) -->
            <div id="section-peta" class="mb-4 table-container d-block pt-2">
                <div class="stat-card-header d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-map-fill text-success fs-4 me-2"></i>
                        <h5 class="stat-card-title m-0">Peta Sebaran Jumlah Pegawai ASN Berdasarkan Provinsi</h5>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fw-semibold rounded-pill mt-2 mt-sm-0">
                        <i class="bi bi-geo-alt me-1"></i>Interactive Map (Leaflet JS)
                    </span>
                </div>

                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-8">
                        <div id="mapProvinsi" style="height: 520px; width: 100%; border-radius: 14px; border: 2px solid #e2e8f0; z-index: 1;"></div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-dark m-0"><i class="bi bi-geo-alt-fill text-success me-2"></i>Sebaran Pegawai Seluruh Provinsi</h6>
                                <span class="badge bg-success-subtle text-success border">38 Provinsi</span>
                            </div>
                            <div class="table-responsive" style="max-height: 440px; overflow-y: auto;">
                                <table class="table table-hover table-sm mb-0" style="font-size: 0.88rem;">
                                    <thead class="table-dark sticky-top">
                                        <tr>
                                            <th>#</th>
                                            <th>Provinsi</th>
                                            <th class="text-end">Jumlah</th>
                                            <th class="text-center">Satker</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataProvinsi as $index => $prov)
                                        <tr onclick="focusProvinceOnMap('{{ $prov['province'] }}', {{ $prov['lat'] }}, {{ $prov['lng'] }})" style="cursor: pointer;" title="Klik untuk fokus lokasi {{ $prov['province'] }} pada peta">
                                            <td>{{ $index + 1 }}</td>
                                            <td class="fw-semibold text-dark">
                                                <i class="bi bi-geo-alt-fill text-success me-1"></i>{{ $prov['province'] }}
                                            </td>
                                            <td class="text-end fw-bold text-success">{{ number_format($prov['total']) }}</td>
                                            <td class="text-center" onclick="event.stopPropagation();">
                                                <button type="button" class="btn btn-xs btn-outline-success py-0 px-2 rounded-pill" onclick="openSatkerModal({{ json_encode($prov) }})" style="font-size:0.75rem;">
                                                    <i class="bi bi-building me-1"></i>Satker
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

                <!-- Tabel Sebaran Data Pegawai per Pulau & Rincian Provinsi -->
                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        <div>
                            <h6 class="fw-bold text-dark mb-1"><i class="bi bi-globe-asia-australia text-success fs-5 me-2"></i>Sebaran Data Pegawai ASN Berdasarkan Pulau & Rincian Provinsi</h6>
                            <p class="text-muted small mb-0">Rincian data persebaran pegawai ASN pada 7 gugus pulau beserta rincian tiap provinsi di wilayahnya</p>
                        </div>
                        <span class="badge bg-success rounded-pill px-3 py-2 mt-2 mt-sm-0">7 Gugus Pulau Utama</span>
                    </div>

                    <!-- Ringkasan Sebaran 7 Gugus Pulau -->
                    <div class="table-responsive shadow-sm rounded-4 border bg-white mb-4">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                            <thead class="table-success text-dark fw-bold">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Wilayah / Pulau</th>
                                    <th class="text-center">Cakupan Provinsi</th>
                                    <th class="text-end">PNS</th>
                                    <th class="text-end">CPNS</th>
                                    <th class="text-end">PPPK</th>
                                    <th class="text-end">PPPK Paruh Waktu</th>
                                    <th class="text-end">Total ASN</th>
                                    <th class="text-end pe-3">% Dari Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotalIsland = array_sum(array_column($dataPulau, 'total')); @endphp
                                @foreach($dataPulau as $index => $pulau)
                                <tr>
                                    <td class="ps-3 fw-bold text-secondary">{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark"><i class="bi bi-geo-fill text-success me-2"></i>{{ $pulau['island'] }}</td>
                                    <td class="text-center"><span class="badge bg-light text-dark border px-2 py-1">{{ $pulau['provinces_count'] }} Provinsi</span></td>
                                    <td class="text-end fw-semibold text-primary">{{ number_format($pulau['pns']) }}</td>
                                    <td class="text-end fw-semibold text-info">{{ number_format($pulau['cpns']) }}</td>
                                    <td class="text-end fw-semibold text-success">{{ number_format($pulau['pppk']) }}</td>
                                    <td class="text-end fw-semibold text-warning">{{ number_format($pulau['pppk_paruh_waktu']) }}</td>
                                    <td class="text-end fw-bold text-dark fs-6">{{ number_format($pulau['total']) }}</td>
                                    <td class="text-end pe-3 fw-bold text-success">{{ $grandTotalIsland > 0 ? number_format(($pulau['total'] / $grandTotalIsland) * 100, 1) : 0 }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Rincian Provinsi per Gugus Pulau -->
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-list-nested text-success me-2"></i>Rincian Provinsi di Setiap Gugus Pulau</h6>
                    <div class="row g-4">
                        @foreach($dataPulau as $pulau)
                        <div class="col-lg-6">
                            <div class="card border shadow-sm rounded-4 h-100">
                                <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between align-items-center py-2 px-3">
                                    <h6 class="fw-bold m-0" style="font-size:0.95rem;"><i class="bi bi-map me-2"></i>Wilayah {{ $pulau['island'] }}</h6>
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
                                                <tr onclick="focusProvinceOnMap('{{ $pDetail['province'] }}', {{ $pDetail['lat'] }}, {{ $pDetail['lng'] }})" style="cursor: pointer;" title="Klik untuk fokus lokasi {{ $pDetail['province'] }} pada peta">
                                                    <td class="ps-3 fw-semibold text-dark">
                                                        <i class="bi bi-geo-alt-fill text-success me-1"></i>{{ $pDetail['province'] }}
                                                    </td>
                                                    <td class="text-end text-primary">{{ number_format($pDetail['pns']) }}</td>
                                                    <td class="text-end text-info">{{ number_format($pDetail['cpns']) }}</td>
                                                    <td class="text-end text-success">{{ number_format($pDetail['pppk']) }}</td>
                                                    <td class="text-end fw-bold text-dark">{{ number_format($pDetail['total']) }}</td>
                                                    <td class="text-center pe-3" onclick="event.stopPropagation();">
                                                        <button type="button" class="btn btn-xs btn-outline-success py-0 px-2 rounded-pill" onclick="openSatkerModal({{ json_encode($pDetail) }})" style="font-size:0.72rem;">
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

            <!-- Modal Detail Satker per Provinsi -->
            <div class="modal fade" id="satkerModal" tabindex="-1" aria-labelledby="satkerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content rounded-4 border-0 shadow-lg">
                        <div class="modal-header bg-success text-white rounded-top-4">
                            <h5 class="modal-header-title modal-title fw-bold" id="satkerModalLabel">
                                <i class="bi bi-building me-2"></i>Daftar Satker di Provinsi <span id="modalProvName"></span>
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                <div>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">
                                        Total Pegawai: <strong id="modalProvTotal">0</strong>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-secondary border px-3 py-2 rounded-pill fw-semibold ms-2">
                                        Total Satker: <strong id="modalSatkerCount">0</strong>
                                    </span>
                                </div>
                                <div class="w-100 w-sm-auto">
                                    <input type="text" id="modalSatkerSearch" class="form-select form-select-sm" placeholder="Cari satker..." onkeyup="filterSatkerModalList()">
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
                                    <tbody id="modalSatkerTbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer bg-light rounded-bottom-4">
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <!-- 1 & 2 Pie Charts -->
            <div id="section-demografi" class="row g-4 mb-4 pt-2">
                <div class="col-lg-6">
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <i class="bi bi-pie-chart-fill text-success fs-4 me-2"></i>
                            <h5 class="stat-card-title">1. Data Berdasarkan Jenis Kelamin</h5>
                        </div>
                        <div class="chart-container">
                            <canvas id="chart1"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <i class="bi bi-geo-alt-fill text-success fs-4 me-2"></i>
                            <h5 class="stat-card-title">2. Data Berdasarkan Lokasi Kerja</h5>
                        </div>
                        <div class="chart-container">
                            <canvas id="chart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3 & 4 Mixed Charts -->
            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <i class="bi bi-bar-chart-line-fill text-success fs-4 me-2"></i>
                            <h5 class="stat-card-title">3. Jenis Pegawai per Jenis Kelamin</h5>
                        </div>
                        <div class="chart-container">
                            <canvas id="chart3"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <i class="bi bi-buildings-fill text-success fs-4 me-2"></i>
                            <h5 class="stat-card-title">4. Data Berdasarkan Lokasi Kerja per Jenis Kelamin</h5>
                        </div>
                        <div class="chart-container">
                            <canvas id="chart4"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Data ASN per ASN Table -->
            <div class="mb-4 table-container d-block">
                <div class="stat-card-header">
                    <i class="bi bi-person-badge-fill text-success fs-4 me-2"></i>
                    <h5 class="stat-card-title">5. Data ASN Kementerian Kehutanan per ASN</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Jenis Jabatan</th>
                                <th>Laki-laki</th>
                                <th>Perempuan</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totL=0; $totP=0; @endphp
                            @foreach($tableAsnPerAsn as $jabatan => $data)
                            @php 
                                $t = $data['Laki-laki'] + $data['Perempuan']; 
                                $totL += $data['Laki-laki'];
                                $totP += $data['Perempuan'];
                            @endphp
                            <tr>
                                <td><i class="bi bi-briefcase me-2 text-muted"></i>{{ $jabatan }}</td>
                                <td class="text-center">{{ number_format($data['Laki-laki']) }}</td>
                                <td class="text-center">{{ number_format($data['Perempuan']) }}</td>
                                <td class="text-center total-col">{{ number_format($t) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-col">
                                <td class="text-end">Total Keseluruhan</td>
                                <td class="text-center">{{ number_format($totL) }}</td>
                                <td class="text-center">{{ number_format($totP) }}</td>
                                <td class="text-center">{{ number_format($totL + $totP) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- 6. Pangkat/Gol PNS -->
            <div id="section-golongan" class="mb-4 table-container d-block pt-2">
                <div class="stat-card-header">
                    <i class="bi bi-award-fill text-success fs-4 me-2"></i>
                    <h5 class="stat-card-title">6. Data ASN berdasarkan Pangkat/Golongan PNS & CPNS</h5>
                </div>
                <div class="chart-container mb-4" style="height: 350px;">
                    <canvas id="chart6"></canvas>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-custom table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Pangkat / Golongan</th>
                                <th>Laki-laki</th>
                                <th>Perempuan</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totL=0; $totP=0; @endphp
                            @foreach($tableGolPnsSummary as $gol => $data)
                            @php 
                                $t = $data['Laki-laki'] + $data['Perempuan'];
                                $totL += $data['Laki-laki'];
                                $totP += $data['Perempuan'];
                            @endphp
                            <tr>
                                <td><i class="bi bi-shield-check me-2 text-muted"></i>Golongan {{ $gol }}</td>
                                <td class="text-center">{{ number_format($data['Laki-laki']) }}</td>
                                <td class="text-center">{{ number_format($data['Perempuan']) }}</td>
                                <td class="text-center total-col">{{ number_format($t) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-col">
                                <td class="text-end">Total</td>
                                <td class="text-center">{{ number_format($totL) }}</td>
                                <td class="text-center">{{ number_format($totP) }}</td>
                                <td class="text-center">{{ number_format($totL + $totP) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- 7. Pangkat/Gol PPPK -->
            <div class="mb-4 table-container d-block">
                <div class="stat-card-header">
                    <i class="bi bi-patch-check-fill text-success fs-4 me-2"></i>
                    <h5 class="stat-card-title">7. Data ASN berdasarkan Golongan PPPK</h5>
                </div>
                <div class="chart-container mb-4" style="height: 350px;">
                    <canvas id="chart7"></canvas>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-custom table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Golongan</th>
                                <th>Laki-laki</th>
                                <th>Perempuan</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totL=0; $totP=0; @endphp
                            @foreach($dataGolonganPppk as $gol => $data)
                            @php 
                                $totL += $data['Laki-laki'];
                                $totP += $data['Perempuan'];
                            @endphp
                            <tr>
                                <td>{{ $gol }}</td>
                                <td class="text-center">{{ number_format($data['Laki-laki']) }}</td>
                                <td class="text-center">{{ number_format($data['Perempuan']) }}</td>
                                <td class="text-center total-col">{{ number_format($data['Total']) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-col">
                                <td class="text-end">Total</td>
                                <td class="text-center">{{ number_format($totL) }}</td>
                                <td class="text-center">{{ number_format($totP) }}</td>
                                <td class="text-center">{{ number_format($totL + $totP) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- 8. Pendidikan -->
            <div id="section-pendidikan" class="mb-4 table-container d-block pt-2">
                <div class="stat-card-header">
                    <i class="bi bi-mortarboard-fill text-success fs-4 me-2"></i>
                    <h5 class="stat-card-title">8. Data ASN berdasarkan Pendidikan</h5>
                </div>
                <div class="chart-container mb-4" style="height: 350px;">
                    <canvas id="chart8"></canvas>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-custom table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Tingkat Pendidikan</th>
                                <th>PNS</th>
                                <th>CPNS</th>
                                <th>PPPK</th>
                                <th>PPPK Paruh Waktu</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $tPns=0; $tCpns=0; $tPppk=0; $tPppkPa=0; $tAll=0; @endphp
                            @foreach($dataPendidikan as $pendId => $d)
                            @php 
                                $tPns += $d['PNS']; $tCpns += $d['CPNS']; $tPppk += $d['PPPK']; $tPppkPa += $d['PPPK Paruh Waktu']; $tAll += $d['Total'];
                            @endphp
                            <tr>
                                <td><i class="bi bi-book me-2 text-muted"></i>{{ $pendId }}</td>
                                <td class="text-center">{{ number_format($d['PNS']) }}</td>
                                <td class="text-center">{{ number_format($d['CPNS']) }}</td>
                                <td class="text-center">{{ number_format($d['PPPK']) }}</td>
                                <td class="text-center">{{ number_format($d['PPPK Paruh Waktu']) }}</td>
                                <td class="text-center total-col">{{ number_format($d['Total']) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-col">
                                <td class="text-end">Total Keseluruhan</td>
                                <td class="text-center">{{ number_format($tPns) }}</td>
                                <td class="text-center">{{ number_format($tCpns) }}</td>
                                <td class="text-center">{{ number_format($tPppk) }}</td>
                                <td class="text-center">{{ number_format($tPppkPa) }}</td>
                                <td class="text-center">{{ number_format($tAll) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- 9. Generasi Usia -->
            <div class="mb-4 table-container d-block">
                <div class="stat-card-header">
                    <i class="bi bi-hourglass-split text-success fs-4 me-2"></i>
                    <h5 class="stat-card-title">9. Data ASN berdasarkan Usia (Generasi)</h5>
                </div>
                <div class="chart-container mb-4" style="height: 350px;">
                    <canvas id="chart9"></canvas>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Generasi</th>
                                <th>PNS</th>
                                <th>CPNS</th>
                                <th>PPPK (Termasuk Paruh Waktu)</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $tPns=0; $tCpns=0; $tPppk=0; $tAll=0; @endphp
                            @foreach($dataGenerasi as $gen => $d)
                            @if($d['Total'] > 0 || $gen != 'Lainnya')
                            @php 
                                $tPns += $d['PNS']; $tCpns += $d['CPNS']; $tPppk += $d['PPPK'] + $d['PPPK Paruh Waktu']; $tAll += $d['Total'];
                            @endphp
                            <tr>
                                <td>{{ $gen }}</td>
                                <td class="text-center">{{ number_format($d['PNS']) }}</td>
                                <td class="text-center">{{ number_format($d['CPNS']) }}</td>
                                <td class="text-center">{{ number_format($d['PPPK'] + $d['PPPK Paruh Waktu']) }}</td>
                                <td class="text-center total-col">{{ number_format($d['Total']) }}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-col">
                                <td class="text-end">Total Keseluruhan</td>
                                <td class="text-center">{{ number_format($tPns) }}</td>
                                <td class="text-center">{{ number_format($tCpns) }}</td>
                                <td class="text-center">{{ number_format($tPppk) }}</td>
                                <td class="text-center">{{ number_format($tAll) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- 10. Eselon I per ASN -->
            <div id="section-eselon" class="mb-4 table-container d-block pt-2">
                <div class="stat-card-header">
                    <i class="bi bi-diagram-3-fill text-success fs-4 me-2"></i>
                    <h5 class="stat-card-title">10. Data ASN Kementerian Kehutanan per Eselon I</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-custom table-hover table-sm" style="font-size: 0.9rem;">
                        <thead>
                            <tr>
                                <th rowspan="2">Unit Eselon I</th>
                                <th colspan="4">Jenis Pegawai</th>
                                <th colspan="3">Jenis Jabatan</th>
                                <th rowspan="2">Total</th>
                            </tr>
                            <tr>
                                <th>PNS</th>
                                <th>CPNS</th>
                                <th>PPPK</th>
                                <th>PPPK Paruh Waktu</th>
                                <th>Struktural</th>
                                <th>Fungsional</th>
                                <th>Pelaksana</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $tPNS=0; $tCPNS=0; $tPPPK=0; $tPPPKPW=0; $tStruk=0; $tFung=0; $tPelak=0; $tTotal=0; 
                            @endphp
                            @foreach($tableEselon1Asn as $name => $d)
                            @php
                                $tPNS += $d['PNS']; $tCPNS += $d['CPNS']; $tPPPK += $d['PPPK']; $tPPPKPW += $d['PPPK Paruh Waktu'];
                                $tStruk += $d['Struktural']; $tFung += $d['Fungsional']; $tPelak += $d['Pelaksana']; $tTotal += $d['Total'];
                            @endphp
                            <tr>
                                <td>{{ $name }}</td>
                                <td class="text-center">{{ number_format($d['PNS']) }}</td>
                                <td class="text-center">{{ number_format($d['CPNS']) }}</td>
                                <td class="text-center">{{ number_format($d['PPPK']) }}</td>
                                <td class="text-center">{{ number_format($d['PPPK Paruh Waktu']) }}</td>
                                <td class="text-center">{{ number_format($d['Struktural']) }}</td>
                                <td class="text-center">{{ number_format($d['Fungsional']) }}</td>
                                <td class="text-center">{{ number_format($d['Pelaksana']) }}</td>
                                <td class="text-center total-col">{{ number_format($d['Total']) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-col">
                                <td class="text-end">Total Keseluruhan</td>
                                <td class="text-center">{{ number_format($tPNS) }}</td>
                                <td class="text-center">{{ number_format($tCPNS) }}</td>
                                <td class="text-center">{{ number_format($tPPPK) }}</td>
                                <td class="text-center">{{ number_format($tPPPKPW) }}</td>
                                <td class="text-center">{{ number_format($tStruk) }}</td>
                                <td class="text-center">{{ number_format($tFung) }}</td>
                                <td class="text-center">{{ number_format($tPelak) }}</td>
                                <td class="text-center">{{ number_format($tTotal) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- 11. Struktural per Eselon I -->
            <div class="mb-4 table-container d-block">
                <div class="stat-card-header">
                    <i class="bi bi-diagram-2-fill text-success fs-4 me-2"></i>
                    <h5 class="stat-card-title">11. Data Jabatan Struktural per Eselon I</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-custom table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Unit Eselon I</th>
                                @foreach($uniqueEselonStruktural as $esKey)
                                <th>Eselon {{ $esKey }}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $colTotals = array_fill_keys($uniqueEselonStruktural->toArray(), 0); 
                                $grandTotal = 0; 
                            @endphp
                            @foreach($tableStrukturalEselon1 as $name => $d)
                            @if($d['Total'] > 0)
                            @php $grandTotal += $d['Total']; @endphp
                            <tr>
                                <td>{{ $name }}</td>
                                @foreach($uniqueEselonStruktural as $esKey)
                                @php $colTotals[$esKey] += ($d[$esKey] ?? 0); @endphp
                                <td class="text-center">{{ number_format($d[$esKey] ?? 0) }}</td>
                                @endforeach
                                <td class="text-center total-col">{{ number_format($d['Total']) }}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-col">
                                <td class="text-end">Total Keseluruhan</td>
                                @foreach($uniqueEselonStruktural as $esKey)
                                <td class="text-center">{{ number_format($colTotals[$esKey]) }}</td>
                                @endforeach
                                <td class="text-center">{{ number_format($grandTotal) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- 12. Kelompok Fungsional -->
            <div class="mb-4 table-container d-block">
                <div class="stat-card-header">
                    <i class="bi bi-people text-success fs-4 me-2"></i>
                    <h5 class="stat-card-title">12. Data ASN per Kelompok Fungsional</h5>
                </div>
                <div class="table-scrollable">
                    <table class="table table-bordered table-custom table-hover table-sm" style="font-size: 0.85rem;">
                        <thead>
                            <tr>
                                <th>Kelompok Fungsional</th>
                                @foreach($uniqueJjg as $jjg)
                                <th>{{ $jjg }}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tableKelompokFungsional as $kel => $d)
                            <tr>
                                <td class="fw-bold">{{ $kel }}</td>
                                @foreach($uniqueJjg as $jjg)
                                <td class="text-center">{{ number_format($d[$jjg] ?? 0) }}</td>
                                @endforeach
                                <td class="text-center total-col">{{ number_format($d['Total']) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 13. Kelompok Fungsional per Eselon I & Satker -->
            <div class="mb-4 table-container d-block">
                <div class="stat-card-header">
                    <i class="bi bi-search text-success fs-4 me-2"></i>
                    <h5 class="stat-card-title">13. Data ASN per Kelompok Fungsional per Eselon I dan Satker</h5>
                </div>
                
                <div class="mb-3 position-relative" style="max-width: 400px;">
                    <i class="bi bi-search position-absolute" style="top: 10px; left: 15px; color: #6c757d;"></i>
                    <input type="text" id="dtSearchTable13" class="form-control ps-5 rounded-pill shadow-sm" placeholder="Cari Unit Eselon I / Satker / Fungsional...">
                </div>

                <div class="table-scrollable">
                    <table class="table table-bordered table-custom table-hover table-sm" style="font-size: 0.85rem;" id="dataTable13">
                        <thead>
                            <tr>
                                <th>Unit Eselon I / Satker / Kelompok Fungsional</th>
                                @foreach($uniqueJjg as $jjg)
                                <th>{{ $jjg }}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="dataTableBody13">
                            @foreach($tableFungsionalDetail as $ue1 => $satkers)
                                @php 
                                    $es1Total = 0;
                                    foreach($satkers as $s) $es1Total += $s['Total Satker']['Total'];
                                    $es1Slug = Str::slug($ue1);
                                @endphp
                                @if($es1Total > 0)
                                    <tr class="table-active fw-bold es1-row" style="background-color: #e2e8f0;" data-es="{{ $es1Slug }}">
                                        <td colspan="{{ count($uniqueJjg) + 2 }}"><i class="bi bi-building me-2 text-success"></i>{{ $ue1 }}</td>
                                    </tr>
                                    @foreach($satkers as $sat => $satData)
                                        @if($satData['Total Satker']['Total'] > 0)
                                        @php $satSlug = Str::slug($sat); @endphp
                                        <tr class="fw-bold bg-light sat-row" data-es="{{ $es1Slug }}" data-sat="{{ $satSlug }}">
                                            <td class="ps-4 text-dark">
                                                <i class="bi bi-diagram-3 text-success me-2"></i> {{ $sat }}
                                            </td>
                                            @foreach($uniqueJjg as $jjg)
                                            <td class="text-center">{{ number_format($satData['Total Satker'][$jjg] ?? 0) }}</td>
                                            @endforeach
                                            <td class="text-center total-col">{{ number_format($satData['Total Satker']['Total']) }}</td>
                                        </tr>
                                        @foreach($satData as $kel => $d)
                                            @if($kel !== 'Total Satker' && $d['Total'] > 0)
                                            <tr class="fgs-row" data-es="{{ $es1Slug }}" data-sat="{{ $satSlug }}">
                                                <td class="ps-5 text-muted">{{ $kel }}</td>
                                                @foreach($uniqueJjg as $jjg)
                                                <td class="text-center">{{ number_format($d[$jjg] ?? 0) }}</td>
                                                @endforeach
                                                <td class="text-center total-col">{{ number_format($d['Total']) }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

</main>
@endsection

@push('scripts')
<script src="{{ asset('dist/leaflet.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.register(ChartDataLabels);
    Chart.defaults.font.family = "'Plus Jakarta Sans', Inter, Roboto, sans-serif";
    Chart.defaults.color = '#475569';
    
    // Rich Brand Colors
    const colors = {
        primary: '#2e7d32',
        secondary: '#0d3b23',
        warning: '#f59e0b',
        danger: '#e11d48',
        info: '#00897b',
        blue: '#2563eb',
        light: '#f1f5f9'
    };

    const barDataLabels = {
        color: '#fff',
        font: { weight: 'bold', size: 11 },
        formatter: (value) => { return value > 0 ? value : ''; }
    };

    // 1. Jenis Kelamin (Pie)
    const jkData = @json($dataJenisKelamin);
    new Chart(document.getElementById('chart1'), {
        type: 'pie',
        data: {
            labels: Object.keys(jkData),
            datasets: [{
                data: Object.values(jkData),
                backgroundColor: [colors.blue, colors.danger],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: { 
            responsive: true, maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    color: '#fff', font: {weight: 'bold', size: 14},
                    formatter: Math.round
                }
            } 
        }
    });

    // 2. Lokasi Kerja (Pie)
    const lokData = @json($dataLokasiKerja);
    new Chart(document.getElementById('chart2'), {
        type: 'pie',
        data: {
            labels: Object.keys(lokData),
            datasets: [{
                data: Object.values(lokData),
                backgroundColor: [colors.primary, colors.warning, colors.info, colors.secondary],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: { 
            responsive: true, maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    color: '#fff', font: {weight: 'bold', size: 14},
                    formatter: (val) => val > 0 ? val : ''
                }
            }
        }
    });

    // 3. Pegawai per Jenis Kelamin (Mixed)
    const cw3Data = @json($dataPegawaiGender);
    const cb3Labels = Object.keys(cw3Data);
    new Chart(document.getElementById('chart3'), {
        type: 'bar',
        data: {
            labels: cb3Labels,
            datasets: [
                {
                    type: 'line',
                    label: 'Total',
                    data: cb3Labels.map(l => cw3Data[l]['Total']),
                    borderColor: colors.warning,
                    backgroundColor: colors.warning,
                    tension: 0.4,
                    borderWidth: 3,
                    datalabels: { align: 'top', anchor: 'end', color: '#000', backgroundColor: '#fff', borderRadius: 4, padding: 4 }
                },
                {
                    label: 'Laki-laki',
                    data: cb3Labels.map(l => cw3Data[l]['Laki-laki']),
                    backgroundColor: colors.blue,
                    borderRadius: 6, datalabels: barDataLabels
                },
                {
                    label: 'Perempuan',
                    data: cb3Labels.map(l => cw3Data[l]['Perempuan']),
                    backgroundColor: colors.danger,
                    borderRadius: 6, datalabels: barDataLabels
                }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });

    // 4. Data Berdasarkan Lokasi Kerja per Jenis kelamin (Mixed)
    const cw4Data = @json($dataLokasiGender);
    const cb4Labels = Object.keys(cw4Data);
    new Chart(document.getElementById('chart4'), {
        type: 'bar',
        data: {
            labels: cb4Labels,
            datasets: [
                {
                    type: 'line',
                    label: 'Total',
                    data: cb4Labels.map(l => cw4Data[l]['Total']),
                    borderColor: colors.secondary,
                    backgroundColor: colors.secondary,
                    tension: 0.4,
                    borderWidth: 3,
                    datalabels: { align: 'top', anchor: 'end', color: '#000', backgroundColor: '#fff', borderRadius: 4, padding: 4 }
                },
                {
                    label: 'Laki-laki',
                    data: cb4Labels.map(l => cw4Data[l]['Laki-laki']),
                    backgroundColor: colors.blue,
                    borderRadius: 6, datalabels: barDataLabels
                },
                {
                    label: 'Perempuan',
                    data: cb4Labels.map(l => cw4Data[l]['Perempuan']),
                    backgroundColor: colors.danger,
                    borderRadius: 6, datalabels: barDataLabels
                }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });

    // 6. Pangkat PNS
    const chart6Data = @json($dataGolonganPns);
    new Chart(document.getElementById('chart6'), {
        type: 'bar',
        data: {
            labels: Object.keys(chart6Data),
            datasets: [{
                label: 'Jumlah PNS & CPNS',
                data: Object.keys(chart6Data).map(k => chart6Data[k]['Total']),
                backgroundColor: colors.primary,
                borderRadius: 6,
                datalabels: { align: 'end', anchor: 'end', color: '#475569', font: {weight: 'bold'} }
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, layout: { padding: {top: 25} } }
    });

    // 7. Pangkat PPPK
    const chart7Data = @json($dataGolonganPppk);
    new Chart(document.getElementById('chart7'), {
        type: 'bar',
        data: {
            labels: Object.keys(chart7Data),
            datasets: [{
                label: 'Jumlah PPPK',
                data: Object.keys(chart7Data).map(k => chart7Data[k]['Total']),
                backgroundColor: colors.info,
                borderRadius: 6,
                datalabels: { align: 'end', anchor: 'end', color: '#475569', font: {weight: 'bold'} }
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, layout: { padding: {top: 25} } }
    });

    // 8. Pendidikan
    const chart8Data = @json($dataPendidikan);
    new Chart(document.getElementById('chart8'), {
        type: 'bar',
        data: {
            labels: Object.keys(chart8Data),
            datasets: [{
                label: 'Total Pegawai',
                data: Object.keys(chart8Data).map(k => chart8Data[k]['Total']),
                backgroundColor: colors.secondary,
                borderRadius: 6,
                datalabels: { align: 'end', anchor: 'end', color: '#475569', font: {weight: 'bold'} }
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, layout: { padding: {top: 25} } }
    });

    // 9. Generasi
    const chart9Data = @json($dataGenerasi);
    const genDataKeys = Object.keys(chart9Data).filter(g => g !== 'Lainnya' || chart9Data[g]['Total'] > 0);
    new Chart(document.getElementById('chart9'), {
        type: 'bar',
        data: {
            labels: genDataKeys,
            datasets: [{
                label: 'Total Pegawai',
                data: genDataKeys.map(k => chart9Data[k]['Total']),
                backgroundColor: colors.warning,
                borderRadius: 6,
                datalabels: { align: 'end', anchor: 'end', color: '#475569', font: {weight: 'bold'} }
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, layout: { padding: {top: 25} } }
    });

    // Ultra-Fast In-Memory Indexed Filter Logic for Table 13
    const searchInput = document.getElementById('dtSearchTable13');
    const tbody13 = document.getElementById('dataTableBody13');

    if (searchInput && tbody13) {
        // Pre-index table structure in memory once for instant search speed
        const allTrs = Array.from(tbody13.querySelectorAll('tr'));
        const indexedRows = allTrs.map(tr => ({
            el: tr,
            text: tr.innerText.toLowerCase(),
            isEs1: tr.classList.contains('es1-row'),
            isSat: tr.classList.contains('sat-row'),
            isFgs: tr.classList.contains('fgs-row'),
            esSlug: tr.dataset.es || '',
            satSlug: tr.dataset.sat || ''
        }));

        // Group rows by Eselon 1 & Satker for quick hierarchy resolution
        const es1Map = new Map();
        indexedRows.forEach(item => {
            if (item.isEs1) {
                es1Map.set(item.esSlug, { header: item, satkers: new Map() });
            }
        });

        indexedRows.forEach(item => {
            if (item.isSat) {
                const es1Obj = es1Map.get(item.esSlug);
                if (es1Obj) {
                    es1Obj.satkers.set(item.satSlug, { header: item, children: [] });
                }
            }
        });

        indexedRows.forEach(item => {
            if (item.isFgs) {
                const es1Obj = es1Map.get(item.esSlug);
                if (es1Obj) {
                    const satObj = es1Obj.satkers.get(item.satSlug);
                    if (satObj) {
                        satObj.children.push(item);
                    }
                }
            }
        });

        let searchTimeout = null;

        function performFastSearch(query) {
            const val = query.trim().toLowerCase();

            if (val === '') {
                allTrs.forEach(tr => tr.style.display = '');
                return;
            }

            // Process hierarchy in memory
            es1Map.forEach(es1Obj => {
                let showEs1 = es1Obj.header.text.includes(val);

                es1Obj.satkers.forEach(satObj => {
                    let showSat = showEs1 || satObj.header.text.includes(val);
                    let hasMatchingChild = false;

                    satObj.children.forEach(child => {
                        const childMatches = child.text.includes(val);
                        if (childMatches) {
                            child.el.style.display = '';
                            hasMatchingChild = true;
                        } else {
                            child.el.style.display = (showSat ? '' : 'none');
                        }
                    });

                    if (hasMatchingChild || showSat) {
                        satObj.header.el.style.display = '';
                        showEs1 = true;
                    } else {
                        satObj.header.el.style.display = 'none';
                    }
                });

                if (showEs1) {
                    es1Obj.header.el.style.display = '';
                } else {
                    es1Obj.header.el.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', function() {
            const query = this.value;
            if (searchTimeout) clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => performFastSearch(query), 30);
        });
    }

    // Leaflet Map Initialization for Public Statistics
    const provData = @json($dataProvinsi);
    if (document.getElementById('mapProvinsi')) {
        const map = L.map('mapProvinsi', {
            center: [-2.5489, 118.0149],
            zoom: 5,
            scrollWheelZoom: true
        });

        window.leafletMapObj = map;
        window.provinceMarkersMap = {};

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors | ROSMO Kementerian Kehutanan'
        }).addTo(map);

        setTimeout(() => {
            map.invalidateSize();
        }, 250);

        provData.forEach(prov => {
            if (prov.total > 0) {
                const radius = Math.max(8, Math.min(32, Math.sqrt(prov.total) * 1.5));
                
                const circle = L.circleMarker([prov.lat, prov.lng], {
                    radius: radius,
                    color: '#0d3b23',
                    fillColor: '#2e7d32',
                    fillOpacity: 0.75,
                    weight: 2
                }).addTo(map);

                window.provinceMarkersMap[prov.province] = circle;

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
                    kotaHtml = `<div style="font-size:0.8rem; color:#64748b; margin-top:2px;"><b>Kota/Kab:</b> ${sampleKota}${extraKota}</div>`;
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
                    <div style="font-family: 'Plus Jakarta Sans', sans-serif; min-width: 240px; padding: 4px;">
                        <h6 style="margin: 0 0 6px 0; color: #0d3b23; font-weight: 700; border-bottom: 2px solid #2e7d32; padding-bottom: 4px;">${prov.province}</h6>
                        ${kotaHtml}
                        <div style="font-size: 0.88rem; color: #334155; margin-top: 6px;">
                            <b>Total Pegawai:</b> <span style="color: #2e7d32; font-weight: 800; font-size: 1.1rem;">${prov.total.toLocaleString()}</span><br>
                            <hr style="margin: 6px 0;">
                            <b>PNS:</b> ${prov.pns.toLocaleString()} | <b>CPNS:</b> ${prov.cpns.toLocaleString()}<br>
                            <b>PPPK:</b> ${prov.pppk.toLocaleString()}<br>
                            <hr style="margin: 6px 0;">
                            <span style="color: #2563eb;"><b>Laki-laki:</b> ${prov.male.toLocaleString()}</span> | 
                            <span style="color: #e11d48;"><b>Perempuan:</b> ${prov.female.toLocaleString()}</span>
                            ${es1Html}
                            ${satkerHtml}
                        </div>
                    </div>
                `;

                circle.bindPopup(popupContent);
                circle.bindTooltip(`<b>${prov.province}</b>: ${prov.total.toLocaleString()} Pegawai`, { direction: 'top', opacity: 0.9 });
            }
        });
    }

    // Fly and Focus Province on Interactive Map
    window.focusProvinceOnMap = function(provName, lat, lng) {
        const mapSection = document.getElementById('section-peta');
        if (mapSection) {
            mapSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        if (window.leafletMapObj) {
            window.leafletMapObj.flyTo([lat, lng], 8, {
                animate: true,
                duration: 1.2
            });
        }

        if (window.provinceMarkersMap && window.provinceMarkersMap[provName]) {
            setTimeout(() => {
                window.provinceMarkersMap[provName].openPopup();
            }, 600);
        }
    };

    // Modal Handler for Satker Details per Province
    window.openSatkerModal = function(provData) {
        document.getElementById('modalProvName').innerText = provData.province;
        document.getElementById('modalProvTotal').innerText = provData.total.toLocaleString();
        
        const satkerEntries = provData.satker ? Object.entries(provData.satker) : [];
        document.getElementById('modalSatkerCount').innerText = satkerEntries.length.toLocaleString();
        document.getElementById('modalSatkerSearch').value = '';

        renderSatkerModalTbody(satkerEntries);
        const modal = new bootstrap.Modal(document.getElementById('satkerModal'));
        modal.show();
    };

    window.currentSatkerEntries = [];

    function renderSatkerModalTbody(entries) {
        window.currentSatkerEntries = entries;
        const tbody = document.getElementById('modalSatkerTbody');
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

    window.filterSatkerModalList = function() {
        const q = document.getElementById('modalSatkerSearch').value.toLowerCase().trim();
        if (!window.currentSatkerEntries) return;
        
        const filtered = window.currentSatkerEntries.filter(e => e[0].toLowerCase().includes(q));
        const tbody = document.getElementById('modalSatkerTbody');
        
        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-3">Tidak ada satker yang cocok dengan pencarian.</td></tr>';
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
