@extends('admin.layouts.app')
@section('page_title', 'Foto Album: ' . ($gallery->title ?: 'Tanpa Judul'))
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.galleries.photos.store', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row align-items-end">
                <div class="col-md-5 mb-3">
                    <label class="form-label">Upload Foto <span class="text-danger">*</span></label>
                    <input type="file" name="image_path" class="form-control" required accept="image/*">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="sort_order" class="form-control" value="0">
                </div>
                <div class="col-md-4 mb-3">
                    <button type="submit" class="btn btn-primary w-100">Upload</button>
                </div>
            </div>
            @error('image_path')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Foto</h5>
        @if(session('success'))
            <div class="alert alert-success mt-2 mb-0">{{ session('success') }}</div>
        @endif
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($photos as $photo)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card h-100">
                    <img src="{{ asset($photo->image_path) }}" class="card-img-top" style="height:120px; object-fit:cover;">
                    <div class="card-footer p-2 bg-white border-0 text-center">
                        <small class="d-block text-muted mb-1">Urutan: {{ $photo->sort_order }}</small>
                        <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger w-100" onclick="return confirm('Hapus foto ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            
            @if($photos->isEmpty())
                <div class="col-12 text-center text-muted">
                    Belum ada foto dalam album ini.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
