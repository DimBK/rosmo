@extends('layouts.app')

@section('body_class', 'blog-page')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{ asset('assets/img/travel/showcase-8.webp') }});">
      <div class="container position-relative">
        <h1>Blog</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="current">Blog</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Search and Filter Section -->
    <section id="blog-search-filter" class="blog-search-filter section pb-0">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <form action="" method="GET" class="row align-items-center gy-3">
          <div class="col-lg-8 col-md-7">
            <div class="search-form position-relative">
              <input type="text" name="search" class="form-control py-2" placeholder="Cari berita..." value="{{ request('search') }}">
              <button type="submit" class="btn btn-primary position-absolute top-50 end-0 translate-middle-y me-1" style="border: none; background: transparent; color: #6c757d;">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-5">
            <div class="filter-form">
              <select name="tagline" class="form-select py-2" onchange="this.form.submit()">
                <option value="">Semua Tagline</option>
                @foreach($tags as $tag)
                <option value="{{ $tag->name }}" {{ request('tagline') == $tag->name ? 'selected' : '' }}>{{ $tag->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </form>
      </div>
    </section><!-- /Search and Filter Section -->

    <!-- Blog Posts Section -->
    <section id="blog-posts" class="blog-posts section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">

          @forelse($newsList as $item)
          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('assets/img/blog/blog-post-1.webp') }}" alt="{{ $item->title }}" class="img-fluid" style="width: 100%; height: 250px; object-fit: cover;">
              </div>

              @if($item->tags->count() > 0)
              <p class="post-category">{{ collect($item->tags)->pluck('name')->join(', ') }}</p>
              @endif

              <h2 class="title">
                <a href="{{ route('news.details', $item->id) }}">{{ $item->title }}</a>
              </h2>

              <div class="d-flex align-items-center">
                <div class="post-meta">
                  <p class="post-date">
                    <time datetime="{{ $item->publish_date }}">{{ \Carbon\Carbon::parse($item->publish_date)->format('M d, Y') }}</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->
          @empty
          <div class="col-12 text-center py-5">
            <p>Tidak ada berita ditemukan.</p>
          </div>
          @endforelse

        </div>
      </div>

    </section><!-- /Blog Posts Section -->

    <!-- Pagination 2 Section -->
    <section id="pagination-2" class="pagination-2 section">

      <div class="container">
        <div class="d-flex justify-content-center">
          {{ $newsList->links('pagination::bootstrap-5') }}
        </div>
      </div>

    </section><!-- /Pagination 2 Section -->

  </main>
@endsection
