@extends('admin.layouts.app')

@section('title', 'Data Statistik Kepegawaian')

@section('header', 'Data Statistik Kepegawaian')

@section('content')
<div class="row">
    <div class="col-12 col-md-4">
        <div class="card mb-4">
            <div class="card-header pb-0 border-bottom-0">
                <h6 class="mb-0">Ringkasan Data</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Total Pegawai Aktif
                        <span class="badge bg-primary rounded-pill">{{ number_format($employeeCount) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Periode Aktif (Terakhir Diimport)
                        <span class="badge bg-info rounded-pill">{{ $statisticsPeriod }}</span>
                    </li>
                    @if($statisticsPeriod !== 'Belum disetel')
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Tipe Periode Aktif
                        <span class="badge bg-secondary rounded-pill">{{ $activeType ?? 'Detail' }}</span>
                    </li>
                    @endif
                </ul>
                
                @if($periods->count() > 0)
                <h6 class="text-sm border-bottom pb-2">Riwayat Periode Tersimpan</h6>
                <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                    <table class="table table-sm text-sm">
                        <tbody>
                            @foreach($periods as $p)
                            <tr class="{{ $p->periode === $statisticsPeriod ? 'table-light fw-bold' : '' }}">
                                <td>{{ $p->periode }}</td>
                                <td class="text-end text-muted">
                                    {{ number_format($p->count) }} data
                                    <span class="badge bg-{{ $p->type === 'Detail' ? 'primary' : 'success' }} text-xxs py-0 px-1">{{ $p->type }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                @if($employeeCount > 0)
                <div class="mt-3">
                    <a href="{{ url('/statistik') }}" target="_blank" class="btn btn-sm btn-outline-primary w-100 mb-0">Lihat Dashboard Frontend</a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-md-8">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Import Data Statistik (Excel)</h6>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                        <span class="text-sm">{{ session('success') }}</span>
                        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible text-white" role="alert">
                        <span class="text-sm">{{ session('error') }}</span>
                        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs mb-4" id="importTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail-import" type="button" role="tab" aria-controls="detail-import" aria-selected="true">
                            <i class="fas fa-users me-2"></i> Mode Detail (Pegawai)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary-import" type="button" role="tab" aria-controls="summary-import" aria-selected="false">
                            <i class="fas fa-chart-pie me-2"></i> Mode Ringkasan (Summary)
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="importTabsContent">
                    <!-- 1. Mode Detail Form -->
                    <div class="tab-pane fade show active" id="detail-import" role="tabpanel" aria-labelledby="detail-tab">
                        <div class="alert alert-info text-white mb-4">
                            <i class="fas fa-info-circle me-1"></i> Format file Excel harus sesuai dengan layout kolom <i>Baseline data.xlsx</i> (Kolom B: UMUR, Kolom C: KEL UMUR, dst.). Baris pertama dianggap sebagai Header. Data lama periode terpilih akan ditimpa!
                        </div>

                        <form action="{{ route('admin.employees.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row align-items-end mb-3">
                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Bulan <span class="text-danger">*</span></label>
                                    <select class="form-control" name="bulan" required>
                                        <option value="">Pilih Bulan</option>
                                        @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $b)
                                            <option value="{{ $b }}" {{ date('n') == $loop->iteration ? 'selected' : '' }}>{{ $b }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Tahun <span class="text-danger">*</span></label>
                                    <select class="form-control" name="tahun" required>
                                        <option value="">Pilih Tahun</option>
                                        @for($y=date('Y'); $y>=2020; $y--)
                                            <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="excel_file" class="form-control-label">File Excel Pegawai Detail (.xlsx, .xls) <span class="text-danger">*</span></label>
                                <input class="form-control @error('excel_file') is-invalid @enderror" type="file" id="excel_file" name="excel_file" accept=".xlsx, .xls" required>
                                @error('excel_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn bg-gradient-primary m-0" onclick="return confirm('Apakah Anda yakin? Seluruh data statistik periode terpilih akan ditimpa dengan data detail pegawai yang baru.')">
                                    <i class="fas fa-upload me-2"></i> Import Data Detail
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- 2. Mode Summary Form -->
                    <div class="tab-pane fade" id="summary-import" role="tabpanel" aria-labelledby="summary-tab">
                        <div class="alert alert-info text-white mb-4 d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-info-circle me-1"></i> Format file Excel untuk Mode Ringkasan harus mengikuti format template resmi yang disediakan. Data lama periode terpilih akan ditimpa!
                            </div>
                            <a href="{{ route('admin.employees.download_template_summary') }}" class="btn btn-xs btn-white mb-0 ms-3 text-nowrap">
                                <i class="fas fa-file-download me-1"></i> Download Template Excel
                            </a>
                        </div>

                        <form action="{{ route('admin.employees.import_summary') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row align-items-end mb-3">
                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Bulan <span class="text-danger">*</span></label>
                                    <select class="form-control" name="bulan" required>
                                        <option value="">Pilih Bulan</option>
                                        @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $b)
                                            <option value="{{ $b }}" {{ date('n') == $loop->iteration ? 'selected' : '' }}>{{ $b }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Tahun <span class="text-danger">*</span></label>
                                    <select class="form-control" name="tahun" required>
                                        <option value="">Pilih Tahun</option>
                                        @for($y=date('Y'); $y>=2020; $y--)
                                            <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="excel_file_summary" class="form-control-label">File Excel Ringkasan (.xlsx, .xls) <span class="text-danger">*</span></label>
                                <input class="form-control @error('excel_file') is-invalid @enderror" type="file" id="excel_file_summary" name="excel_file" accept=".xlsx, .xls" required>
                                @error('excel_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn bg-gradient-success m-0" onclick="return confirm('Apakah Anda yakin? Seluruh data statistik periode terpilih akan ditimpa dengan data ringkasan (summary) yang baru.')">
                                    <i class="fas fa-upload me-2"></i> Import Data Ringkasan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
