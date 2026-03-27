@extends('admin.layouts.app')
@section('page_title', 'Daftar Pengumuman')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary btn-sm">Tambah Pengumuman</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead><tr><th>ID</th><th>Title</th><th>Publish Date</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($announcements as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->publish_date }}</td>
                    <td>
                        <a href="{{ route('admin.announcements.edit', $item) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.announcements.destroy', $item) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus pengumuman ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection