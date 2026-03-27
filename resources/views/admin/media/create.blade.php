@extends('admin.layouts.app')
@section('page_title', 'Upload Media')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Pilih File (Bisa multi-upload)</label>
                <input type="file" name="files[]" class="form-control" multiple accept="image/*,video/mp4" required>
                <small class="text-muted">Format: JPG, PNG, WEBP, GIF, SVG, MP4. (Gambar otomatis di-compress ke WebP jika resolusi besar).</small>
            </div>
            <button class="btn btn-primary">Upload</button>
            <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
