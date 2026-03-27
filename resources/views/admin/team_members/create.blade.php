@extends('admin.layouts.app')
@section('page_title', 'Tambah Anggota Tim')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.team_members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Jabatan (Role)</label>
                <input type="text" name="role" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control" value="0" required>
            </div>
            <div class="mb-3">
                <label>Foto Profiles</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.team_members.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
