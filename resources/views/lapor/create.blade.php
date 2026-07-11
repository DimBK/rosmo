@extends('lapor.layouts.app')

@section('title', 'Buka Tiket Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Form Buka Tiket Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('lapor.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subjek Laporan / Pertanyaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Detail Pesan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('lapor.dashboard') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Kirim Tiket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
