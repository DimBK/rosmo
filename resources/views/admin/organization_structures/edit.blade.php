@extends('admin.layouts.app')

@section('title', 'Edit Struktur Organisasi')
@section('page_title', 'Edit Struktur Organisasi')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Form Edit Posisi</h3>
            </div>
            
            <form action="{{ route('admin.organization_structures.update', $structure->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="position_name" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('position_name') is-invalid @enderror" id="position_name" name="position_name" value="{{ old('position_name', $structure->position_name) }}" required>
                        @error('position_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="official_name" class="form-label">Nama Pejabat</label>
                        <input type="text" class="form-control @error('official_name') is-invalid @enderror" id="official_name" name="official_name" value="{{ old('official_name', $structure->official_name) }}">
                        @error('official_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="echelon" class="form-label">Tingkat Eselon / Keterangan</label>
                        <input type="text" class="form-control @error('echelon') is-invalid @enderror" id="echelon" name="echelon" value="{{ old('echelon', $structure->echelon) }}">
                        @error('echelon') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Atasan (Hirarki Di Bawah)</label>
                        <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                            <option value="">-- Tidak Ada Atasan (Level Tertinggi) --</option>
                            @foreach($allStructures as $struct)
                                <option value="{{ $struct->id }}" {{ old('parent_id', $structure->parent_id) == $struct->id ? 'selected' : '' }}>
                                    {{ $struct->position_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Urutan Tampil (Sort Order)</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $structure->sort_order) }}">
                        <small class="form-text text-muted">Makin kecil angkanya, makin ke kiri/atas urutannya.</small>
                        @error('sort_order') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Pejabat</label>
                        @if($structure->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $structure->image) }}" alt="Foto Pejabat" class="img-thumbnail" width="150">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        <small class="form-text text-muted">Abaikan jika tidak ingin mengubah foto.</small>
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                    <a href="{{ route('admin.organization_structures.index') }}" class="btn btn-default float-end">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
