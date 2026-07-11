@extends('admin.layouts.app')
@section('page_title', 'Edit Pengguna')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label>NIP (18 digit angka)</label>
                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $user->nip) }}" placeholder="Contoh: 199912312023101001" maxlength="18" pattern="[0-9]{18}">
                @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="mb-3">
                <label>Peran (Role)</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label>Status Akun</label>
                <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" required {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    <option value="1" {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', $user->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @if($user->id === auth()->id())
                    <input type="hidden" name="is_active" value="1">
                    <small class="text-muted">Anda tidak dapat menonaktifkan akun Anda sendiri.</small>
                @endif
                @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
