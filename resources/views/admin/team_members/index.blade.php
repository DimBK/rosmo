@extends('admin.layouts.app')
@section('page_title', 'Tim Kami')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.team_members.create') }}" class="btn btn-primary btn-sm">Tambah Anggota Tim</a>
        @if(session('success'))
            <div class="alert alert-success mt-2 mb-0">{{ session('success') }}</div>
        @endif
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jabatan (Role)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($team as $member)
                <tr>
                    <td>{{ $member->sort_order }}</td>
                    <td>
                        @if($member->photo)
                            <img src="{{ asset($member->photo) }}" height="50" alt="{{ $member->name }}">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->role }}</td>
                    <td>
                        <a href="{{ route('admin.team_members.edit', $member) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.team_members.destroy', $member) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus anggota tim ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
