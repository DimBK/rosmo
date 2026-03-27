@extends('admin.layouts.app')
@section('page_title', 'Tambah Pengumuman')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.announcements.store') }}" method="POST">
            @csrf
            <div class="mb-3"><label>Judul</label><input type="text" name="title" class="form-control" required></div>
            <div class="mb-3"><label>Konten</label><textarea name="content" class="form-control" rows="4" required></textarea></div>
            <div class="mb-3"><label>Tanggal Publish</label><input type="date" name="publish_date" class="form-control"></div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection