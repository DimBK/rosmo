@extends('layouts.app')

@section('body_class', 'tour-details-page')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{ $service->image ? asset('storage/'.$service->image) : asset('assets/img/travel/showcase-8.webp') }});">
      <div class="container position-relative">
        <h1>{{ $service->title }}</h1>
        <p>Detail tata cara dan persyaratan untuk pengajuan layanan {{ $service->title }}.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="current">{{ Str::limit($service->title, 60) }}</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Travel Tour Details Section -->
    <section id="travel-tour-details" class="travel-tour-details section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Hero Section -->
        @if($service->image)
        <div class="tour-hero">
          <div class="hero-image-wrapper">
            <img src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->title }}" class="img-fluid w-100" style="max-height: 500px; object-fit: cover;">
          </div>
        </div>
        @endif

        <!-- Tour Overview -->
        <div class="tour-overview" data-aos="fade-up" data-aos-delay="200" style="padding-top: 40px;">
          <div class="row">
            <div class="{{ $service->highlights ? 'col-lg-8' : 'col-lg-12' }}">
              <h2>{{ $service->title }}</h2>
              <div class="content-body" style="line-height: 1.8; text-align: justify; font-size: 1.05rem;">
                {!! $service->content !!}
              </div>
            </div>
            @if($service->highlights)
            <div class="col-lg-4">
              <div class="tour-highlights">
                <h3>Sorotan Layanan</h3>
                <div class="highlights-body">
                  {!! $service->highlights !!}
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>

        @if($service->included || $service->not_included)
        <!-- Inclusions -->
        <div class="tour-inclusions" data-aos="fade-up" data-aos-delay="400">
          <div class="row">
            @if($service->included)
            <div class="col-lg-6">
              <div class="included-section">
                <h3><i class="bi bi-check-circle-fill"></i> Persyaratan Wajib</h3>
                <div class="inclusion-body">
                  {!! $service->included !!}
                </div>
              </div>
            </div>
            @endif
            @if($service->not_included)
            <div class="col-lg-6">
              <div class="excluded-section">
                <h3 style="color: var(--bs-warning);"><i class="bi bi-info-circle-fill" style="color: var(--bs-warning);"></i> Persyaratan Opsional</h3>
                <div class="exclusion-body">
                  {!! $service->not_included !!}
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        @endif

        <!-- Meta Info (Last Edited & Regulation Source) -->
        <div class="mt-5 pt-4 border-top" style="color: var(--default-color);">
          <div class="card border-0 shadow-sm" style="background-color: color-mix(in srgb, var(--background-color), var(--default-color) 2%); border-radius: 8px;">
            <div class="card-body p-4">
              <div class="row">
                <div class="col-lg-7 mb-4 mb-lg-0">
                  <h5 class="d-flex align-items-center mb-3" style="font-weight: 600; font-size: 1.1rem; color: var(--accent-color);">
                    <i class="bi bi-journal-text me-2" style="font-size: 1.3rem;"></i>
                    Sumber Regulasi & Dasar Hukum
                  </h5>
                  @if($service->regulation_source)
                    @php
                      $sources = preg_split('/[;\n]+/', $service->regulation_source);
                      $sources = array_filter(array_map('trim', $sources));
                    @endphp
                    @if(!empty($sources))
                      <ol class="ps-3 mb-0" style="line-height: 1.6; font-size: 0.95rem;">
                        @foreach($sources as $source)
                          <li class="mb-2"><strong>{{ $source }}</strong></li>
                        @endforeach
                      </ol>
                    @else
                      <span class="text-muted" style="font-size: 0.95rem;">Tidak ada data regulasi khusus.</span>
                    @endif
                  @else
                    <span class="text-muted" style="font-size: 0.95rem;">Tidak ada data regulasi khusus.</span>
                  @endif
                </div>
                <div class="col-lg-5 d-flex flex-column justify-content-between text-lg-end">
                  <div>
                    <h5 class="mb-3" style="font-weight: 600; font-size: 1.1rem; color: var(--accent-color);">
                      <i class="bi bi-clock-history me-2" style="font-size: 1.3rem;"></i>
                      Status Informasi
                    </h5>
                    <p class="mb-2 text-muted" style="font-size: 0.95rem;">
                      Terakhir Diperbarui:&nbsp;<strong class="text-dark">{{ $service->updated_at ? $service->updated_at->timezone('Asia/Jakarta')->format('d-m-Y') : '-' }}</strong>
                    </p>
                    <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.5;">
                      Pastikan Anda selalu memeriksa pembaruan regulasi kepegawaian terbaru sesuai dengan peraturan yang berlaku.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Travel Tour Details Section -->

  </main>
@endsection
