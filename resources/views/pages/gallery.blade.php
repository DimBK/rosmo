@extends('layouts.app')

@section('body_class', 'gallery-page')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{ asset('assets/img/travel/showcase-8.webp') }});">
      <div class="container position-relative">
        <h1>Gallery</h1>
        <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="current">Gallery</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    @if($randomPhotos->isNotEmpty())
    <!-- Gallery Slider Section -->
    <section id="gallery-slider" class="gallery-slider section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="gallery-container">
          <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
              {
                "loop": true,
                "speed": 800,
                "autoplay": {
                  "delay": 4000
                },
                "effect": "coverflow",
                "grabCursor": true,
                "centeredSlides": true,
                "slidesPerView": "auto",
                "coverflowEffect": {
                  "rotate": 50,
                  "stretch": 0,
                  "depth": 100,
                  "modifier": 1,
                  "slideShadows": true
                },
                "pagination": {
                  "el": ".swiper-pagination",
                  "type": "bullets",
                  "clickable": true
                },
                "navigation": {
                  "nextEl": ".swiper-button-next",
                  "prevEl": ".swiper-button-prev"
                },
                "breakpoints": {
                  "320": {
                    "slidesPerView": 1,
                    "spaceBetween": 10
                  },
                  "768": {
                    "slidesPerView": 2,
                    "spaceBetween": 20
                  },
                  "1024": {
                    "slidesPerView": 3,
                    "spaceBetween": 30
                  }
                }
              }
            </script>
            <div class="swiper-wrapper">
              @foreach($randomPhotos as $photo)
              <div class="swiper-slide">
                <div class="gallery-item">
                  <div class="gallery-img">
                    <a class="glightbox" data-gallery="featured-gallery" href="{{ asset($photo->image_path) }}">
                      <img src="{{ asset($photo->image_path) }}" class="img-fluid" alt="" style="object-fit: cover; height: 350px; width: 100%;">
                      <div class="gallery-overlay">
                        <i class="bi bi-plus-circle"></i>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
      </div>
    </section><!-- /Gallery Slider Section -->
    @endif

    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
          <ul class="gallery-filters isotope-filters" data-aos="fade-up" data-aos-delay="200">
            <li data-filter="*" class="filter-active">Semua Album</li>
          </ul>

          <div class="row gallery-grid isotope-container" data-aos="fade-up" data-aos-delay="300">
            @forelse($galleries as $gallery)
            <div class="col-xl-4 col-md-6 gallery-item isotope-item">
              <div class="gallery-card">
                <div class="gallery-image">
                  <img src="{{ asset($gallery->image_path) }}" class="img-fluid w-100" style="height: 300px; object-fit: cover;" alt="{{ $gallery->title }}">
                </div>
                <div class="gallery-overlay">
                  <h4>{{ $gallery->title ?: 'Tanpa Judul' }}</h4>
                  <p>{{ $gallery->photos->count() }} Foto</p>
                  <div class="gallery-actions">
                    <!-- Album Cover Trigger -->
                    <a href="{{ asset($gallery->image_path) }}" title="{{ $gallery->title }}" class="glightbox" data-gallery="album-{{ $gallery->id }}">
                        <i class="bi bi-images"></i> Lihat Album
                    </a>
                    
                    <!-- Hidden gallery photos -->
                    @foreach($gallery->photos as $photo)
                        <a href="{{ asset($photo->image_path) }}" title="{{ $gallery->title }}" class="glightbox d-none" data-gallery="album-{{ $gallery->id }}"></a>
                    @endforeach
                  </div>
                </div>
              </div>
            </div><!-- End Gallery Album Item -->
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada album galeri yang tersedia.</p>
            </div>
            @endforelse
          </div>
        </div>
      </div>
    </section><!-- /Gallery Section -->

  </main>
@endsection
