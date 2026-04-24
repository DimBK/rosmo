@extends('layouts.app')

@section('body_class', 'statistik-page')

@push('styles')
<style>
    .statistik-hero {
        padding: 120px 0 60px 0;
        background: linear-gradient(135deg, #051e23 0%, #1a4a52 100%);
        color: white;
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        height: 100%;
        transition: transform 0.3s ease;
    }
    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #051e23;
        line-height: 1.2;
    }
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .chart-container {
        position: relative;
        height: 350px;
        width: 100%;
    }
    .period-badge {
        background: rgba(255,255,255,0.2);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        backdrop-filter: blur(5px);
    }
    .table-container {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .table-custom th {
        background-color: #051e23;
        color: white;
        text-align: center;
        vertical-align: middle;
    }
    .table-custom td {
        vertical-align: middle;
    }
    .table-custom .total-col {
        font-weight: bold;
        background-color: #f8f9fa;
    }
</style>
@endpush

@section('content')
<main class="main">

    <!-- Hero Section -->
    <section class="statistik-hero">
        <div class="container" data-aos="fade-up">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div class="mb-3 mb-md-0">
                    <h1 class="mb-2">Dashboard Statistik Kepegawaian</h1>
                    <p class="mb-0 text-white-50">Kementerian Kehutanan Republik Indonesia</p>
                </div>
                <div class="period-badge">
                    <form action="" method="GET" class="d-flex align-items-center m-0">
                        <i class="bi bi-calendar3 me-2 text-white"></i>
                        <span class="text-white me-2">Periode:</span>
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
                    <div class="stat-card text-center d-flex flex-column justify-content-center">
                        <div class="stat-value text-primary" data-purecounter-start="0" data-purecounter-end="{{ $totalAsn }}" data-purecounter-duration="1" class="purecounter">{{ number_format($totalAsn) }}</div>
                        <div class="stat-label mt-2">TOTAL PEGAWAI</div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-6">
                    <div class="row g-4 h-100">
                        <div class="col-md-3 col-6">
                            <div class="stat-card text-center text-md-start">
                                <div class="stat-value fs-3" data-purecounter-start="0" data-purecounter-end="{{ $totalPns }}" data-purecounter-duration="1" class="purecounter">{{ number_format($totalPns) }}</div>
                                <div class="stat-label">PNS</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-card text-center text-md-start">
                                <div class="stat-value fs-3" data-purecounter-start="0" data-purecounter-end="{{ $totalCpns }}" data-purecounter-duration="1" class="purecounter">{{ number_format($totalCpns) }}</div>
                                <div class="stat-label">CPNS</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-card text-center text-md-start">
                                <div class="stat-value fs-3" data-purecounter-start="0" data-purecounter-end="{{ $totalPppk }}" data-purecounter-duration="1" class="purecounter">{{ number_format($totalPppk) }}</div>
                                <div class="stat-label">PPPK</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-card text-center text-md-start">
                                <div class="stat-value fs-3" data-purecounter-start="0" data-purecounter-end="{{ $totalPppkParuhWaktu }}" data-purecounter-duration="1" class="purecounter">{{ number_format($totalPppkParuhWaktu) }}</div>
                                <div class="stat-label">PPPK Paruh Waktu</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Charts Section -->
    <section class="section bg-light pt-5 pb-5">
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <!-- 1 & 2 Pie Charts -->
            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <div class="stat-card">
                        <h5 class="mb-4">1. Data Berdasarkan Jenis Kelamin</h5>
                        <div class="chart-container">
                            <canvas id="chart1"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="stat-card">
                        <h5 class="mb-4">2. Data Berdasarkan Lokasi Kerja</h5>
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
                        <h5 class="mb-4">3. Jenis Pegawai per Jenis Kelamin</h5>
                        <div class="chart-container">
                            <canvas id="chart3"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="stat-card">
                        <h5 class="mb-4">4. Data Berdasarkan Lokasi Kerja per Jenis Kelamin</h5>
                        <div class="chart-container">
                            <canvas id="chart4"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Data ASN per ASN Table -->
            <div class="mb-4 table-container d-block">
                <h5 class="mb-4">5. Data ASN Kementerian Kehutanan per ASN</h5>
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
                                <td>{{ $jabatan }}</td>
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
            <div class="mb-4 table-container d-block">
                <h5 class="mb-4">6. Data ASN berdasarkan Pangkat/Golongan PNS & CPNS</h5>
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
                                <td>Golongan {{ $gol }}</td>
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
                <h5 class="mb-4">7. Data ASN berdasarkan Golongan PPPK</h5>
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
            <div class="mb-4 table-container d-block">
                <h5 class="mb-4">8. Data ASN berdasarkan Pendidikan</h5>
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
                                <td>{{ $pendId }}</td>
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
                <h5 class="mb-4">9. Data ASN berdasarkan Usia (Generasi)</h5>
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
            <div class="mb-4 table-container d-block">
                <h5 class="mb-4">10. Data ASN Kementerian Kehutanan per Eselon I</h5>
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
                <h5 class="mb-4">11. Data Jabatan Struktural per Eselon I</h5>
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
                <h5 class="mb-4">12. Data ASN per Kelompok Fungsional</h5>
                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-bordered table-custom table-hover table-sm" style="font-size: 0.85rem;">
                        <thead style="position: sticky; top: -1px; z-index: 10;">
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
                <h5 class="mb-4">13. Data ASN per Kelompok Fungsional per Eselon I dan Satker</h5>
                
                <div class="mb-3 position-relative" style="max-width: 400px;">
                    <i class="bi bi-search position-absolute" style="top: 10px; left: 15px; color: #6c757d;"></i>
                    <input type="text" id="dtSearchTable13" class="form-control ps-5 rounded-pill" placeholder="Cari Unit Eselon I / Satker / Fungsional...">
                </div>

                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-bordered table-custom table-hover table-sm" style="font-size: 0.85rem;" id="dataTable13">
                        <thead style="position: sticky; top: -1px; z-index: 10;">
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
                                    // Generate a slug to link children to parent rows for JS filtering
                                    $es1Slug = Str::slug($ue1);
                                @endphp
                                @if($es1Total > 0)
                                    <tr class="table-active fw-bold es1-row" style="background-color: #e9ecef;" data-es="{{ $es1Slug }}">
                                        <td colspan="{{ count($uniqueJjg) + 2 }}">{{ $ue1 }}</td>
                                    </tr>
                                    @foreach($satkers as $sat => $satData)
                                        @if($satData['Total Satker']['Total'] > 0)
                                        @php $satSlug = Str::slug($sat); @endphp
                                        <tr class="fw-bold bg-light sat-row" data-es="{{ $es1Slug }}" data-sat="{{ $satSlug }}">
                                            <td class="ps-4">
                                                <i class="bi bi-diagram-3 me-2"></i> {{ $sat }}
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.register(ChartDataLabels);
    Chart.defaults.font.family = 'Inter, Roboto, sans-serif';
    Chart.defaults.color = '#495057';
    
    // Core brand colors
    const colors = {
        primary: '#20a39e',
        secondary: '#051e23',
        warning: '#ffba49',
        danger: '#ef5b5b',
        info: '#23001e',
        light: '#e9ecef',
        gray: '#ced4da'
    };

    // Shared config for bar chart datalabels
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
                backgroundColor: [colors.primary, colors.danger, colors.warning],
                borderWidth: 0
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
                backgroundColor: [colors.secondary, colors.warning, colors.primary, colors.danger],
                borderWidth: 0
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
                    backgroundColor: colors.primary,
                    borderRadius: 4, datalabels: barDataLabels
                },
                {
                    label: 'Perempuan',
                    data: cb3Labels.map(l => cw3Data[l]['Perempuan']),
                    backgroundColor: colors.danger,
                    borderRadius: 4, datalabels: barDataLabels
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
                    backgroundColor: colors.primary,
                    borderRadius: 4, datalabels: barDataLabels
                },
                {
                    label: 'Perempuan',
                    data: cb4Labels.map(l => cw4Data[l]['Perempuan']),
                    backgroundColor: colors.danger,
                    borderRadius: 4, datalabels: barDataLabels
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
                borderRadius: 4,
                datalabels: { align: 'end', anchor: 'end', color: '#495057', font: {weight: 'bold'} }
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
                backgroundColor: colors.danger,
                borderRadius: 4,
                datalabels: { align: 'end', anchor: 'end', color: '#495057', font: {weight: 'bold'} }
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
                borderRadius: 4,
                datalabels: { align: 'end', anchor: 'end', color: '#495057', font: {weight: 'bold'} }
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
                borderRadius: 4,
                datalabels: { align: 'end', anchor: 'end', color: '#495057', font: {weight: 'bold'} }
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, layout: { padding: {top: 25} } }
    });

    // JS Filter logic for Table 13
    const searchInput = document.getElementById('dtSearchTable13');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filterVal = this.value.toLowerCase();
            const tbody = document.getElementById('dataTableBody13');
            const es1Rows = tbody.querySelectorAll('.es1-row');

            if (filterVal === '') {
                // Show everything
                tbody.querySelectorAll('tr').forEach(tr => tr.style.display = '');
                return;
            }

            // Hide everything first
            tbody.querySelectorAll('tr').forEach(tr => tr.style.display = 'none');

            // Pass 1: find matches
            es1Rows.forEach(esRow => {
                const esSlug = esRow.dataset.es;
                const esMatches = esRow.innerText.toLowerCase().includes(filterVal);
                let showEs = esMatches;
                
                const satRows = tbody.querySelectorAll(`.sat-row[data-es="${esSlug}"]`);
                satRows.forEach(satRow => {
                    const satSlug = satRow.dataset.sat;
                    const satMatches = satRow.innerText.toLowerCase().includes(filterVal);
                    let showSat = esMatches || satMatches;
                    
                    const fgsRows = tbody.querySelectorAll(`.fgs-row[data-sat="${satSlug}"][data-es="${esSlug}"]`);
                    fgsRows.forEach(fgsRow => {
                        const fgsMatches = fgsRow.innerText.toLowerCase().includes(filterVal);
                        if (fgsMatches) {
                            showSat = true;
                            showEs = true;
                            fgsRow.style.display = '';
                        } else {
                            if (showSat && (esMatches || satMatches)) fgsRow.style.display = '';
                        }
                    });
                    
                    if (showSat) satRow.style.display = '';
                });
                
                if (showEs) esRow.style.display = '';
            });
        });
    }

});
</script>
@endpush
