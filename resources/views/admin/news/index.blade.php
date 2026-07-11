@extends('admin.layouts.app')
@section('page_title', 'Daftar Berita')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm">Tambah Berita</a>
        <form action="{{ route('admin.news.index') }}" method="GET" class="d-flex" style="max-width: 300px;">
            <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control" placeholder="Cari judul berita..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-danger">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Title</th>
                    <th style="width: 150px;">Publish Date</th>
                    <th style="width: 150px;">Status</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($news as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->publish_date }}</td>
                    <td>
                        <form action="{{ route('admin.news.toggle-status', $item) }}" method="POST" class="d-inline">
                            @csrf
                            <div class="form-check form-switch d-inline-flex align-items-center">
                                <input class="form-check-input me-2" type="checkbox" role="switch" onchange="this.form.submit()" {{ $item->status ? 'checked' : '' }}>
                                <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }}" style="font-size: 0.75rem;">
                                    {{ $item->status ? 'Active' : 'Draft' }}
                                </span>
                            </div>
                        </form>
                    </td>
                    <td>
                        @if(!$item->status)
                            <a href="{{ route('news.details', $item) }}" class="btn btn-sm btn-outline-primary me-1" title="Preview Draft" target="_blank">
                                <i class="bi bi-eye"></i>
                            </a>
                        @endif
                        <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-info text-white me-1" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus berita ini?')" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection