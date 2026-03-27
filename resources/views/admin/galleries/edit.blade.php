@extends('admin.layouts.app')
@section('page_title', 'Edit Galeri')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Judul / Keterangan (Opsional)</label>
                <input type="text" name="title" class="form-control" value="{{ $gallery->title }}">
            </div>
            <div class="mb-3">
                <label>Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control" value="{{ $gallery->sort_order }}" required>
            </div>
            <div class="mb-3">
                <label>Gambar Galeri</label>
                <div class="mb-2"><img src="{{ asset($gallery->image_path) }}" height="150" alt="Gallery"></div>
                <input type="file" name="image_path" class="form-control" accept="image/*">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
