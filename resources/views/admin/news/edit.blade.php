@extends('admin.layouts.app')
@section('page_title', 'Edit Berita')
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

        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="row g-3 mb-4">
                <!-- Judul Berita -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Judul Berita</label>
                    <input type="text" name="title" class="form-control" value="{{ $news->title }}" required placeholder="Ketik judul berita...">
                </div>
                <!-- Tanggal Publish -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Publish</label>
                    <input type="date" name="publish_date" class="form-control" value="{{ $news->publish_date }}">
                </div>
            </div>

            <div class="row g-3 mb-4">
                <!-- Status -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status Berita</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ $news->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$news->status ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <!-- Tags -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Tags (Topik Terkait)</label>
                    <select name="tags[]" class="form-select select2-tags" multiple="multiple">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ $news->tags->contains($tag->id) ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Gambar Utama -->
            <div class="card mb-4 bg-light border-0 shadow-none">
                <div class="card-body p-3">
                    <label class="form-label fw-semibold d-block">Gambar Cover Utama</label>
                    @if($news->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$news->image) }}" alt="Preview Cover" class="rounded border" style="max-height: 150px; object-fit: cover;">
                            <small class="text-muted d-block mt-1">Cover aktif saat ini</small>
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Format file: png, jpg, jpeg. Maksimal ukuran 2MB.</small>
                </div>
            </div>

            <!-- Existing Gallery Photos -->
            <div class="card mb-4 border-0 bg-light shadow-none">
                <div class="card-body p-3">
                    <label class="form-label fw-semibold d-block mb-3">Galeri Foto Berita (Maksimal 10 Foto)</label>
                    @if($news->photos->count() > 0)
                        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-3 mb-3">
                            @foreach($news->photos as $photo)
                                <div class="col">
                                    <div class="card h-100 border-0 shadow-sm rounded overflow-hidden">
                                        <img src="{{ asset('storage/' . $photo->path) }}" class="card-img-top" style="height: 100px; object-fit: cover;">
                                        <div class="card-footer bg-white border-0 text-center py-2">
                                            <div class="form-check d-inline-block">
                                                <input class="form-check-input text-danger" type="checkbox" name="delete_photos[]" value="{{ $photo->id }}" id="delete_photo_{{ $photo->id }}">
                                                <label class="form-check-label text-danger fw-semibold small" for="delete_photo_{{ $photo->id }}" style="cursor: pointer;">
                                                    Hapus
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="alert alert-warning-light p-2 mb-0 d-flex align-items-center" style="font-size: 0.85rem; background: #fffaf0; border: 1px solid #ffe8cc; border-radius: 6px; color: #b05c00;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Centang foto yang ingin dihapus, lalu klik Update Berita di bawah.
                        </div>
                    @else
                        <span class="text-muted d-block py-2"><i class="bi bi-image-fill me-1"></i> Belum ada foto di galeri berita ini.</span>
                    @endif
                </div>
            </div>

            <!-- Upload New Photos -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Tambah Foto Baru ke Galeri</label>
                <input type="file" name="gallery[]" class="form-control" multiple accept=".png,.jpg,.jpeg,.gif,.webp,.svg,.heic,.heif,.hevc">
                <small class="text-muted">Format file yang didukung: png, jpg, jpeg, webp, gif, svg, HEIC, HEIF, HEVC. Ukuran maks. 2MB per file. Foto berukuran besar akan otomatis dikompresi.</small>
            </div>

            <!-- Konten Editor -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Isi Konten Berita</label>
                <textarea id="contentEditor" name="content" class="form-control" rows="8" required>{{ $news->content }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="pt-3 border-top d-flex justify-content-between">
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary px-3"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                <button class="btn btn-success px-4"><i class="bi bi-save me-1"></i> Update Berita</button>
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