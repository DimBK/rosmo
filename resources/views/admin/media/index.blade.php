@extends('admin.layouts.app')
@section('page_title', 'Media Library')
@push('styles')
<style>
.media-card { height: 100%; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
.media-img { width: 100%; height: 150px; object-fit: cover; background: #f8f9fa; }
</style>
@endpush
@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title m-0">Semua Media</h3>
        <a href="{{ route('admin.media.create') }}" class="btn btn-primary btn-sm">Upload File Baru</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="row g-3">
            @foreach($media as $item)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="media-card">
                    @if(in_array(pathinfo($item->file_path, PATHINFO_EXTENSION), ['mp4']))
                        <div class="media-img d-flex align-items-center justify-content-center bg-secondary text-white">
                            <i class="bi bi-camera-video fs-1"></i>
                        </div>
                    @else
                        <img src="{{ asset($item->file_path) }}" class="media-img" alt="{{ $item->file_name }}" loading="lazy">
                    @endif
                    <div class="p-2">
                        <small class="d-block text-truncate" title="{{ $item->file_name }}">{{ $item->file_name }}</small>
                        <small class="text-muted">{{ $item->file_size ? $item->file_size . ' KB' : 'N/A' }}</small>
                        <div class="mt-2">
                            <button type="button" class="btn btn-xs btn-outline-secondary copy-btn" data-url="{{ asset($item->file_path) }}">Copy URL</button>
                            <form action="{{ route('admin.media.destroy', $item) }}" method="POST" class="d-inline float-end">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-outline-danger" onclick="return confirm('Hapus file ini?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $media->links() }}
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.querySelectorAll('.copy-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        navigator.clipboard.writeText(this.dataset.url).then(() => {
            const temp = this.innerText;
            this.innerText = 'Copied!';
            setTimeout(() => this.innerText = temp, 2000);
        });
    });
});
</script>
@endpush
