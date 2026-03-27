@extends('admin.layouts.app')
@section('page_title', 'Tambah Galeri')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Judul / Keterangan (Opsional)</label>
                <input type="text" name="title" class="form-control">
            </div>
            <div class="mb-3">
                <label>Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control" value="0" required>
            </div>
            <div class="mb-3">
                <label>Gambar Galeri</label>
                <input type="file" name="image_path" class="form-control" accept="image/*" required>
                <small class="text-muted">Otomatis dicompress jika ukurannya besar.</small>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
