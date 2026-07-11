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
                    <th>NIP</th>
                    <th>Email</th>
                    <th>Peran (Role)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->nip ?? '-' }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'super_admin')
                            <span class="badge text-bg-danger">Super Admin</span>
                        @else
                            <span class="badge text-bg-info">Editor</span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge text-bg-success">Aktif</span>
                        @else
                            <span class="badge text-bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info text-white">Edit</a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @if($user->is_active)
                                <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Nonaktifkan pengguna ini?')">Nonaktifkan</button>
                            @else
                                <button type="submit" class="btn btn-sm btn-success text-white" onclick="return confirm('Aktifkan pengguna ini?')">Aktifkan</button>
                            @endif
                        </form>
                        <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#resetPasswordModal-{{ $user->id }}">Reset Password</button>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus pengguna ini?')">Delete</button>
                        </form>

                        <!-- Modal Reset Password -->
                        <div class="modal fade" id="resetPasswordModal-{{ $user->id }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="resetPasswordModalLabel-{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.users.reset-password', $user) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="resetPasswordModalLabel-{{ $user->id }}">Reset Password: {{ $user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label for="password-{{ $user->id }}" class="form-label">Password Baru</label>
                                                <input type="password" name="password" id="password-{{ $user->id }}" class="form-control" minlength="8" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password_confirmation-{{ $user->id }}" class="form-label">Konfirmasi Password Baru</label>
                                                <input type="password" name="password_confirmation" id="password_confirmation-{{ $user->id }}" class="form-control" minlength="8" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning text-white">Reset Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
