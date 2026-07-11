@extends('admin.layouts.app')
@section('page_title', 'Tambah Pengguna')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label>NIP (18 digit angka)</label>
                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" placeholder="Contoh: 199912312023101001" maxlength="18" pattern="[0-9]{18}">
                @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Peran (Role)</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label>Status Akun</label>
                <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', '1') == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
