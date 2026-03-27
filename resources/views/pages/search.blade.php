@extends('layouts.app')

@section('page_title', 'Hasil Pencarian')

@section('content')
<main class="main" style="padding-top: 120px; min-height: 80vh;">
  <div class="container section-title" data-aos="fade-up">
    <h2>Pencarian</h2>
    <div><span>Hasil Pencarian:</span> <span class="description-title">"{{ $q }}"</span></div>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <!-- News Results -->
    <h3 class="mb-4">Berita ({{ $newsResults->count() }})</h3>
    <div class="row gy-4 mb-5">
      @forelse($newsResults as $item)
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="tour-card" style="font-size: 0.9rem; transform: scale(0.95); margin: -10px;">
          <div class="tour-image">
            <img src="{{ $item->image ? asset('storage/'.$item->image) : asset('assets/img/travel/tour-1.webp') }}" alt="{{ $item->title }}" class="img-fluid" style="width: 100%; height: 200px; object-fit: cover;" loading="lazy">
          </div>
          <div class="tour-content">
            <h4>{{ $item->title }}</h4>
            <div class="tour-meta d-flex align-items-center">
              <span class="duration me-3"><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($item->publish_date ?? $item->created_at)->format('d F Y') }}</span>
              <span class="text-muted" style="font-size: 0.85rem;"><i class="bi bi-eye"></i> {{ number_format($item->views) }} views</span>
              <a href="{{ route('news.details', $item) }}" class="btn btn-sm btn-outline-primary ms-auto" style="border-radius: 20px;">Baca</a>
            </div>
            <p>{{ Str::limit(strip_tags($item->content), 100) }}</p>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12 text-muted">Tidak ada berita yang cocok dengan kata kunci ini.</div>
      @endforelse
    </div>

    <hr>
    
    <!-- Announcement Results -->
    <h3 class="mb-4 mt-5">Pengumuman & Peraturan ({{ $announcementResults->count() }})</h3>
    <div class="row gy-4 pb-5">
      @forelse($announcementResults as $item)
      <div class="col-lg-6 col-md-12" data-aos="fade-up" data-aos-delay="200">
        <div class="card p-3 shadow-sm border-0" style="border-left: 4px solid #2ba28a !important;">
          <h5 class="text-primary" style="color: #2ba28a !important;">{{ $item->title }}</h5>
          <small class="text-muted mb-2"><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($item->publish_date ?? $item->created_at)->format('d F Y') }}</small>
          <p class="mb-0">{{ Str::limit(strip_tags($item->content), 120) }}</p>
        </div>
      </div>
      @empty
      <div class="col-12 text-muted pb-4">Tidak ada pengumuman/peraturan yang cocok dengan kata kunci.</div>
      @endforelse
    </div>
  </div>
</main>
@endsection
