@extends('admin.layouts.app')
@section('title', 'Manajemen Tag')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Tag</h3>
                <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-sm">Tambah Tag</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->slug }}</td>
                            <td>
                                <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tag ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
