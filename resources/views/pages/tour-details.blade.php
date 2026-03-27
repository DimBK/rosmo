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

        <!-- Removed extra sections as requested -->

      </div>

    </section><!-- /Travel Tour Details Section -->

  </main>
@endsection
