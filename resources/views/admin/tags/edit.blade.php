@extends('admin.layouts.app')
@section('title', 'Edit Tag')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Tag</h3>
            </div>
            <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">Nama Tag</label>
                        <input type="text" name="name" class="form-control" id="name" required value="{{ old('name', $tag->name) }}">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-default">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
