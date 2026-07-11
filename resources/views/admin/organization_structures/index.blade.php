@extends('admin.layouts.app')

@section('title', 'Struktur Organisasi')
@section('page_title', 'Struktur Organisasi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Struktur Organisasi</h3>
                <div class="card-tools d-flex gap-2">
                    <a href="{{ route('admin.organization_structures.export') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                        <i class="bi bi-upload"></i> Import Excel
                    </button>
                    <a href="{{ route('admin.organization_structures.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Posisi
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Form Pencarian & Filter -->
                <form action="{{ route('admin.organization_structures.index') }}" method="GET" class="mb-4 bg-light p-3 rounded border">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label for="q" class="form-label text-sm fw-bold">Kata Kunci</label>
                            <input type="text" name="q" id="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama jabatan, pejabat, eselon...">
                        </div>
                        <div class="col-md-4">
                            <label for="parent_id" class="form-label text-sm fw-bold">Atasan</label>
                            <select name="parent_id" id="parent_id" class="form-select">
                                <option value="">Semua Atasan</option>
                                @foreach($allParents as $p)
                                    <option value="{{ $p->id }}" {{ request('parent_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->position_name }} {{ $p->official_name ? '(' . $p->official_name . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 mb-0">
                                <i class="bi bi-search"></i> Cari
                            </button>
                            <a href="{{ route('admin.organization_structures.index') }}" class="btn btn-outline-secondary w-100 mb-0">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Urutan</th>
                                <th>Foto</th>
                                <th>Nama Jabatan</th>
                                <th>Nama Pejabat</th>
                                <th>Eselon</th>
                                <th>Atasan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($structures as $structure)
                            <tr>
                                <td>{{ $structure->sort_order }}</td>
                                <td>
                                    @if($structure->image)
                                        <img src="{{ asset('storage/' . $structure->image) }}" alt="Foto" width="50" class="img-thumbnail">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $structure->position_name }}</td>
                                <td>{{ $structure->official_name ?? '-' }}</td>
                                <td>{{ $structure->echelon ?? '-' }}</td>
                                <td>{{ $structure->parent ? $structure->parent->position_name : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.organization_structures.edit', $structure->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.organization_structures.destroy', $structure->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data struktur organisasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.organization_structures.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="importExcelModalLabel">Import Data Pejabat via Excel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-muted mb-3"><small>Silakan Export format Excel terlebih dahulu, isi kolom "Nama Pejabat", dan unggah kembali di sini. <b>Jangan ubah kolom ID.</b></small></p>
          <div class="mb-3">
            <label for="excel_file" class="form-label">Berkas Excel (.xlsx / .xls)</label>
            <input class="form-control" type="file" id="excel_file" name="excel_file" accept=".xlsx, .xls, .csv" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Unggah & Import</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
