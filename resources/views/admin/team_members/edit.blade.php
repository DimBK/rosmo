@extends('admin.layouts.app')
@section('page_title', 'Edit Anggota Tim')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.team_members.update', $teamMember) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $teamMember->name }}" required>
            </div>
            <div class="mb-3">
                <label>Jabatan (Role)</label>
                <input type="text" name="role" class="form-control" value="{{ $teamMember->role }}" required>
            </div>
            <div class="mb-3">
                <label>Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control" value="{{ $teamMember->sort_order }}" required>
            </div>
            <div class="mb-3">
                <label>Foto Profiles</label>
                @if($teamMember->photo)
                    <div class="mb-2"><img src="{{ asset($teamMember->photo) }}" height="100"></div>
                @endif
                <input type="file" name="photo" class="form-control" accept="image/*">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.team_members.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
