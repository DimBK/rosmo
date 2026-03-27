@extends('admin.layouts.app')
@section('page_title', 'Tambah Persyaratan Layanan')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.service_requirements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label>Pilih Induk Kategori (Opsional)</label>
                <select name="parent_id" class="form-select">
                    <option value="">-- Menjadi Induk Utama --</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Pilih induk jika layanan ini merupakan sub-menu.</small>
            </div>

            <div class="mb-3">
                <label>Judul Layanan</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label>Gambar Header (Opsional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            
            <div class="mb-3">
                <label>Konten Persyaratan</label>
                <textarea id="contentEditor" name="content" class="form-control" rows="10" required></textarea>
            </div>
            
            <div class="mb-3">
                <label>Sorotan Layanan (Highlights)</label>
                <textarea id="highlightsEditor" name="highlights" class="form-control" rows="5"></textarea>
            </div>
            
            <div class="mb-3">
                <label>Persyaratan Wajib (Included)</label>
                <textarea id="includedEditor" name="included" class="form-control" rows="5"></textarea>
            </div>
            
            <div class="mb-3">
                <label>Opsional / Tidak Termasuk (Not Included)</label>
                <textarea id="notIncludedEditor" name="not_included" class="form-control" rows="5"></textarea>
            </div>
            
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="1">Aktif</option>
                    <option value="0">Draft</option>
                </select>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.service_requirements.index') }}" class="btn btn-secondary">Batal</a>
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
