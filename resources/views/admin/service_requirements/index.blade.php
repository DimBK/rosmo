@extends('admin.layouts.app')
@section('page_title', 'Data Persyaratan Layanan')
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <a href="{{ route('admin.service_requirements.create') }}" class="btn btn-primary btn-sm">Tambah Layanan</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Layanan</th>
                        <th>Induk (Parent)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->parent ? $item->parent->title : '-' }}</td>
                        <td>
                            @if($item->status)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('layanan/'.$item->slug) }}" target="_blank" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('admin.service_requirements.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.service_requirements.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data persyaratan layanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
