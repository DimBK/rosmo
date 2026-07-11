@extends('admin.layouts.app')
@section('page_title', 'Edit Persyaratan Layanan')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.service_requirements.update', $service_requirement) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <h5 class="mb-3 text-success fw-bold"><i class="bi bi-info-circle me-1"></i> Informasi Dasar Layanan</h5>
            <div class="row g-3 mb-4">
                <!-- Induk Kategori -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Pilih Induk Kategori (Opsional)</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- Menjadi Induk Utama --</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $service_requirement->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Pilih induk jika layanan ini merupakan sub-menu.</small>
                </div>
                <!-- Judul Layanan -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Judul Layanan</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $service_requirement->title) }}" required placeholder="Contoh: Kenaikan Pangkat PNS">
                </div>
            </div>

            <div class="row g-3 mb-4">
                <!-- Gambar Header -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Gambar Header (Opsional)</label>
                    @if($service_requirement->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$service_requirement->image) }}" alt="Preview" class="rounded border" style="max-height: 100px; object-fit: cover;">
                            <small class="text-muted d-block mt-1">Gambar aktif saat ini</small>
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <!-- Status -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ old('status', $service_requirement->status ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status', $service_requirement->status ? '1' : '0') == '0' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>

            <!-- Sumber Regulasi -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Sumber Regulasi / Peraturan</label>
                <input type="text" name="regulation_source" class="form-control" value="{{ old('regulation_source', $service_requirement->regulation_source) }}" placeholder="Contoh: UU No. 20/2023; Peraturan BKN No. 1/2024">
                <small class="text-muted">Gunakan tanda titik koma (`;`) sebagai pemisah jika peraturan lebih dari satu.</small>
            </div>

            <hr class="my-4">

            <h5 class="mb-3 text-success fw-bold"><i class="bi bi-file-earmark-text me-1"></i> Rincian & Persyaratan Dokumen</h5>
            
            <!-- Konten Persyaratan -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi / Konten Persyaratan</label>
                <textarea id="contentEditor" name="content" class="form-control" rows="8">{{ old('content', $service_requirement->content) }}</textarea>
            </div>
            
            <!-- Sorotan Layanan -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Sorotan Layanan (Highlights)</label>
                <textarea id="highlightsEditor" name="highlights" class="form-control" rows="5">{{ old('highlights', $service_requirement->highlights) }}</textarea>
            </div>
            
            <div class="row g-3 mb-4">
                <!-- Persyaratan Wajib -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-success"><i class="bi bi-check-circle-fill me-1"></i> Persyaratan Wajib (Included)</label>
                    <textarea id="includedEditor" name="included" class="form-control" rows="5">{{ old('included', $service_requirement->included) }}</textarea>
                </div>
                <!-- Opsional -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-danger"><i class="bi bi-x-circle-fill me-1"></i> Opsional / Tidak Termasuk (Not Included)</label>
                    <textarea id="notIncludedEditor" name="not_included" class="form-control" rows="5">{{ old('not_included', $service_requirement->not_included) }}</textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-3 border-top d-flex justify-content-between">
                <a href="{{ route('admin.service_requirements.index') }}" class="btn btn-secondary px-3"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                <button class="btn btn-success px-4"><i class="bi bi-save me-1"></i> Update Layanan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if(typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('contentEditor', { versionCheck: false });
            CKEDITOR.replace('highlightsEditor', { versionCheck: false, height: 150 });
            CKEDITOR.replace('includedEditor', { versionCheck: false, height: 150 });
            CKEDITOR.replace('notIncludedEditor', { versionCheck: false, height: 150 });
        }
    });
</script>
@endpush
@endsection
