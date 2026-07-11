@extends('admin.layouts.app')
@section('page_title', 'Tambah Berita')
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

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-3 mb-4">
                <!-- Judul Berita -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Judul Berita</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Ketik judul berita...">
                </div>
                <!-- Tanggal Publish -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Publish</label>
                    <input type="date" name="publish_date" class="form-control" value="{{ old('publish_date') }}">
                </div>
            </div>

            <div class="row g-3 mb-4">
                <!-- Status -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status Berita</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <!-- Tags -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Tags (Topik Terkait)</label>
                    <select name="tags[]" class="form-select select2-tags" multiple="multiple">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Gambar Utama -->
            <div class="card mb-4 bg-light border-0 shadow-none">
                <div class="card-body p-3">
                    <label class="form-label fw-semibold d-block">Gambar Cover Utama</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Format file: png, jpg, jpeg. Maksimal ukuran 2MB.</small>
                </div>
            </div>

            <!-- Upload Gallery Photos -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Galeri Foto Berita (Opsional, Maksimal 10 Foto)</label>
                <input type="file" name="gallery[]" class="form-control" multiple accept=".png,.jpg,.jpeg,.gif,.webp,.svg,.heic,.heif,.hevc">
                <small class="text-muted">Format file yang didukung: png, jpg, jpeg, webp, gif, svg, HEIC, HEIF, HEVC. Ukuran maks. 2MB per file. Foto berukuran besar akan otomatis dikompresi.</small>
            </div>

            <!-- Konten Editor -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Isi Konten Berita</label>
                <textarea id="contentEditor" name="content" class="form-control" rows="8" required>{{ old('content') }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="pt-3 border-top d-flex justify-content-between">
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary px-3"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                <button class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Berita</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-tags').select2({
            theme: 'bootstrap-5',
            tags: true,
            placeholder: 'Pilih atau ketik tag baru...',
            tokenSeparators: [',']
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        if(typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('contentEditor', {
                versionCheck: false
            });
        }
    });
</script>
@endpush
@endsection