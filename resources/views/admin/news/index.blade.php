@extends('admin.layouts.app')
@section('page_title', 'Daftar Berita')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm">Tambah Berita</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead><tr><th>ID</th><th>Title</th><th>Publish Date</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($news as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->publish_date }}</td>
                    <td>{{ $item->status ? 'Active' : 'Draft' }}</td>
                    <td>
                        <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus berita ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection