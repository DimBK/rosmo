@extends('admin.layouts.app')
@section('page_title', 'Tambah Berita')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3"><label>Judul</label><input type="text" name="title" class="form-control" required></div>
            <div class="mb-3"><label>Gambar Utama (Opsional)</label><input type="file" name="image" class="form-control" accept="image/*"></div>
            <div class="mb-3"><label>Konten</label><textarea id="contentEditor" name="content" class="form-control" rows="5" required></textarea></div>
            <div class="mb-3"><label>Tanggal Publish</label><input type="date" name="publish_date" class="form-control"></div>
            <div class="mb-3"><label>Status</label><select name="status" class="form-select"><option value="1">Active</option><option value="0">Draft</option></select></div>
            <div class="mb-3">
                <label>Tags (Related Topics)</label>
                <select name="tags[]" class="form-select select2-tags" multiple="multiple">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Simpan</button>
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