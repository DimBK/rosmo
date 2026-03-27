@extends('admin.layouts.app')
@section('page_title', 'Edit Pengumuman')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3"><label>Judul</label><input type="text" name="title" class="form-control" value="{{ $announcement->title }}" required></div>
            <div class="mb-3"><label>Konten</label><textarea name="content" class="form-control" rows="4" required>{{ $announcement->content }}</textarea></div>
            <div class="mb-3"><label>Tanggal Publish</label><input type="date" name="publish_date" class="form-control" value="{{ $announcement->publish_date }}"></div>
            <button class="btn btn-success">Update</button>
        </form>
    </div>
</div>
@endsection