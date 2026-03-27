@extends('admin.layouts.app')
@section('page_title', 'Daftar Pengguna')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">Tambah Pengguna</a>
        @if(session('success'))
            <div class="alert alert-success mt-2 mb-0">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mt-2 mb-0">{{ session('error') }}</div>
        @endif
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran (Role)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'super_admin')
                            <span class="badge text-bg-danger">Super Admin</span>
                        @else
                            <span class="badge text-bg-info">Editor</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info">Edit</a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus pengguna ini?')">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
