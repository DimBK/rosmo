@extends('layouts.app')

@section('body_class', 'blog-details-page')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{ asset('assets/img/travel/back3.jpg') }});">
      <div class="container position-relative">
        <h1>Detail Berita</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="current">{{ Str::limit($news->title, 60) }}</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Tag berita -->
    <section id="blog-details" class="blog-details section">
      <div class="container" data-aos="fade-up">

        <article class="article">
          <div class="article-header">
            <div class="meta-categories" data-aos="fade-up">
              <a href="#" class="category">Berita</a>
            </div>

            <h1 class="title" data-aos="fade-up" data-aos-delay="100">{{ $news->title }}</h1>


            <!-- Detail admin -->
            <div class="article-meta" data-aos="fade-up" data-aos-delay="200">
              <div class="author">
                <img src="{{ asset('assets/img/person/person-m-6.webp') }}" alt="Author" class="author-img">
                <div class="author-info">
                  <h4>Admin</h4>
                  <span>Tim Sosial Media Rosmo</span>
                </div>
              </div>
              <div class="post-info">
                <span><i class="bi bi-calendar4-week"></i> {{ \Carbon\Carbon::parse($news->publish_date ?? $news->created_at)->format('d F Y') }}</span>
              </div>
            </div>
          </div>

          <!-- Detail gambar/banner -->
          <div class="article-featured-image" data-aos="zoom-in">
            <img src="{{ $news->image ? asset('storage/'.$news->image) : asset('assets/img/blog/blog-hero-1.webp') }}" alt="{{ $news->title }}" class="img-fluid">
          </div>

          <!-- Table Detail Segment Berita -->
          <div class="article-wrapper d-block">


            <!-- Isi Berita -->
            <div class="article-content" id="contentEditor" data-aos="fade-up" style="word-wrap: break-word;">
               @if($news->content === strip_tags($news->content))
                   {!! nl2br(e($news->content)) !!}
               @else
                   {!! $news->content !!}
               @endif
            </div>
          </div>

          <!-- detail share -->
          <div class="article-footer" data-aos="fade-up">
            <div class="share-article">
              <h4>Bagikan Berita</h4>
              <div class="share-buttons">
                <a href="#" class="share-button twitter">
                  <i class="bi bi-twitter-x"></i>
                  <span>Bagikan di X</span>
                </a>
                <a href="#" class="share-button facebook">
                  <i class="bi bi-facebook"></i>
                  <span>Bagikan di Facebook</span>
                </a>
                <a href="#" class="share-button linkedin">
                  <i class="bi bi-link"></i>
                  <span>Bagikan Link Berita</span>
                </a>                
              </div>
            </div>

            <div class="article-tags">
              <h4>Related Topics</h4>
              <div class="tags">
                @forelse($news->tags as $tag)
                  <a href="{{ route('search', ['q' => $tag->name]) }}" class="tag">{{ $tag->name }}</a>
                @empty
                  <span class="text-muted" style="font-size: 0.9rem;">Belum ada topik terkait.</span>
                @endforelse
              </div>
            </div>
          </div>

        </article>

        <!-- Post Pagination -->
        <div class="post-pagination d-flex justify-content-between mt-5" data-aos="fade-up">
            @if(isset($previous) && $previous)
                <div class="prev-post">
                    <a href="{{ route('news.details', $previous) }}" class="d-flex align-items-center text-decoration-none">
                        <i class="bi bi-arrow-left me-2 fs-4"></i>
                        <div>
                            <span class="text-muted d-block" style="font-size: 0.85rem;">Berita Sebelumnya</span>
                            <span class="text-dark fw-bold">{{ Str::limit($previous->title, 40) }}</span>
                        </div>
                    </a>
                </div>
            @else
                <div></div>
            @endif

            @if(isset($next) && $next)
                <div class="next-post text-end">
                    <a href="{{ route('news.details', $next) }}" class="d-flex align-items-center justify-content-end text-decoration-none">
                        <div class="text-end">
                            <span class="text-muted d-block" style="font-size: 0.85rem;">Berita Selanjutnya</span>
                            <span class="text-dark fw-bold">{{ Str::limit($next->title, 40) }}</span>
                        </div>
                        <i class="bi bi-arrow-right ms-2 fs-4"></i>
                    </a>
                </div>
            @else
                <div></div>
            @endif
        </div><!-- End Post Pagination -->

      </div>
    </section><!-- /Blog Details Section -->

    <!-- Comments section intentionally hidden per request -->

  </main>
@endsection
