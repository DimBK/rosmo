@extends('admin.layouts.app')
@section('page_title', 'Galeri')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary btn-sm">Tambah Galeri</a>
        @if(session('success'))
            <div class="alert alert-success mt-2 mb-0">{{ session('success') }}</div>
        @endif
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($galleries as $gallery)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <img src="{{ asset($gallery->image_path) }}" class="card-img-top" alt="{{ $gallery->title }}" style="height:200px; object-fit:cover;">
                    <div class="card-body p-2">
                        <small class="d-block fw-bold text-truncate">{{ $gallery->title ?: 'Tanpa Judul' }}</small>
                        <small class="text-muted">Urutan: {{ $gallery->sort_order }}</small>
                    </div>
                    <div class="card-footer p-2 bg-white border-0">
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm btn-info w-100 mb-1">Edit</a>
                        <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger w-100" onclick="return confirm('Hapus galeri ini?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-3">
            {{ $galleries->links() }}
        </div>
    </div>
</div>
@endsection
