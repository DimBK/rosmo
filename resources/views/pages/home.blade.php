@extends('layouts.app')

@section('body_class', 'index-page')

@section('content')
<main class="main">

    <!-- Travel Hero Section -->
    <section id="travel-hero" class="travel-hero section dark-background">

      <div class="hero-background">
        <video autoplay="" muted="" loop="">
          <source src="{{ asset('assets/img/travel/banner.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
      </div>

      <div class="container position-relative">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <div class="hero-text" data-aos="fade-up" data-aos-delay="100">
              <div class="mb-2">
                <img src="{{ asset('assets/img/apple-touch-icon.png') }}" alt="Logo ROSMO" style="height: 30px;">
              </div>
              <span class="tagline">Kementerian Kehutanan</span>
              <h1 class="hero-title">Biro Sumber Daya Manusia dan Organisasi</h1>
              <p class="hero-subtitle">Rosmo hadir untuk menyajikan informasi terkini seputar kepegawaian, kegiatan biro, regulasi, statistik SDM, hingga inovasi layanan digital yang sedang dikembangkan.</p>
              <div class="hero-buttons">
                <a href="#featured-destinations" class="btn btn-primary me-3">Layanan kami</a>
                <a href="{{ url('blog') }}" class="btn btn-outline">Berita Terkini</a>
              </div>
            </div>
          </div>
      </div>
      </div>

      <div class="scroll-indicator" data-aos="fade-up" data-aos-delay="100">
        <div class="scroll-text">Scroll to Explore</div>
        <div class="scroll-arrow">
            <i class="bi bi-chevron-down"></i>
        </div>
      </div>

    </section><!-- /Travel Hero Section -->

    <!-- Featured Destinations Section -->
    <section id="featured-destinations" class="featured-destinations section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>***</h2>
        <div><span>Layanan</span> <span class="description-title">Kami</span></div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">

          <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="featured-destination">
              <div class="destination-overlay">
                <img src="{{ asset('assets/img/alam.jpeg') }}" alt="Tropical Paradise" class="img-fluid">
                <div class="destination-info">
                  <span class="destination-tag">Integrated</span>
                  <h3>Sistem Informasi Manajemen Kepegawaian (SIMPEG)</h3>
                  <p class="description">Bagian dari transformasi digital manajemen ASN, yang bertujuan mewujudkan tata kelola kepegawaian yang efektif, efisien, dan transparan</p>
                  <a href="https://simpeg.kehutanan.go.id/" class="explore-btn">
                    <span>Login</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="row g-3">

              <div class="col-12" data-aos="fade-left" data-aos-delay="300">
                <div class="compact-destination">
                  <div class="destination-image">
                    <img src="{{ asset('assets/img/cpns.jpg') }}" alt="Mountain Adventure" class="img-fluid">
                  </div>
                  <div class="destination-details">
                    <h4>Pengadaan Calon Aparatur Sipil Negara (CASN)</h4>
                    <p class="brief">Bergabunglah bersama kami menjadi bagian dari ASN yang profesional, berintegritas, dan berdedikasi untuk membangun Indonesia</p>
                    <a href="https://casn.kehutanan.go.id/" class="quick-link">View Details <i class="bi bi-chevron-right"></i></a>
                  </div>
                </div>
              </div>

              <div class="col-12" data-aos="fade-left" data-aos-delay="400">
                <div class="compact-destination">
                  <div class="destination-image">
                    <img src="{{ asset('assets/img/pelantikan.jpeg') }}" alt="Cultural Heritage" class="img-fluid">
                  </div>
                  <div class="destination-details">
                    <h4>Seleksi Jabatan Pimpinan Tinggi (JPT)</h4>
                    <p class="brief">Dapatkan informasi resmi mengenai tahapan, persyaratan, dan hasil seleksi Jabatan Pimpinan Tinggi di lingkungan Kementerian Kehutanan</p>
                    <a href="https://seleksijpt.kehutanan.go.id/" class="quick-link">View Details <i class="bi bi-chevron-right"></i></a>
                  </div>
                </div>
              </div>

              <div class="col-12" data-aos="fade-left" data-aos-delay="500">
                <div class="compact-destination">
                  <div class="destination-image">
                    <img src="{{ asset('assets/img/sikadir.jpg') }}" alt="Safari Experience" class="img-fluid">
                    <div class="badge-offer limited">Integrated</div>
                  </div>
                  <div class="destination-details">
                    <h4>Sistem Rekam Kehadiran ASN Terintegrasi (SIKADIR)</h4>
                    <p class="brief">Sistem absensi ini dikembangkan untuk meningkatkan efisiensi dan akurasi data kehadiran pegawai di lingkungan Kementerian Kehutanan</p>
                    <a href="https://sikadirklhk.id/" class="quick-link">View Details <i class="bi bi-chevron-right"></i></a>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>

      </div>

    </section><!-- /Featured Destinations Section -->


    <!-- Berita -->
    <section id="featured-tours" class="featured-tours section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>***</h2>
        <div><span>Berita</span> <span class="description-title">Terkini</span></div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
          @forelse($news as $item)
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('news.details', $item) }}" style="color: inherit; text-decoration: none;">
              <div class="tour-card" style="font-size: 0.9rem; transform: scale(0.95); margin: -10px;">
                <div class="tour-image">
                <img src="{{ $item->image ? asset('storage/'.$item->image) : asset('assets/img/travel/tour-1.webp') }}" alt="{{ $item->title }}" class="img-fluid" style="width: 100%; height: 200px; object-fit: cover;" loading="lazy">
              </div>
              <div class="tour-content">
                <h4>{{ $item->title }}</h4>
                <div class="tour-meta">
                  <span class="duration"><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($item->publish_date ?? $item->created_at)->format('d F Y') }}</span>
                </div>
                <p>{{ Str::limit(strip_tags($item->content), 100) }}</p>
                <div class="tour-highlights d-flex justify-content-between align-items-center mt-3">
                  <div>
                    @forelse($item->tags->take(2) as $tag)
                      <span>{{ $tag->name }}</span>
                    @empty
                      <span>Berita</span>
                    @endforelse
                  </div>
                  <span class="text-muted" style="background: none; padding: 0; font-size: 0.85rem;"><i class="bi bi-eye"></i> {{ number_format($item->views) }}</span>
                </div>
              </div>
            </div>
            </a>
          </div><!-- End Tour Item -->
          @empty
          <div class="col-12 text-center text-muted">
            <p>Belum ada berita yang diterbitkan.</p>
          </div>
          @endforelse
        </div>

        <!-- Removed pagination as news is limited to 6 on home -->

        <div class="text-center mt-3" data-aos="fade-up" data-aos-delay="500">
          <a href="{{ url('blog') }}" class="btn-view-all">Cek Berita Lainnya</a>
        </div>

      </div>

    </section><!-- /Featured Tours Section -->

    <!-- Why Us Section -->
    <section id="why-us" class="why-us section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- About Us Content -->
        <div class="row align-items-center mb-5">
          
          <!-- Kolom kiri untuk konten -->
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="content">
              <h3>Dashboard Statistik SDM</h3>
              <p class="justified-text">Dashboard Statistik Kepegawaian menyajikan data dan informasi terkini mengenai kondisi ASN di lingkungan Kementerian Kehutanan secara interaktif dan mudah dipahami. Melalui fitur ini, pengguna dapat memantau jumlah dan sebaran pegawai berdasarkan unit kerja, golongan, jabatan, usia, serta tingkat pendidikan guna mendukung pengambilan keputusan yang cepat, akurat, dan berbasis data.</p>
              
              <div class="stats-row">
                <div class="stat-item">
                  <span data-purecounter-start="5000" data-purecounter-end="20945" data-purecounter-duration="2" class="purecounter">20.945</span>
                  <div class="stat-label">ASN</div>
                </div>
                <div class="stat-item">
                  <span data-purecounter-start="5000" data-purecounter-end="13595" data-purecounter-duration="2" class="purecounter">13.595</span>
                  <div class="stat-label">PNS</div>
                </div>
                <div class="stat-item">
                  <span data-purecounter-start="5000" data-purecounter-end="7350" data-purecounter-duration="2" class="purecounter">7.350</span>
                  <div class="stat-label">PPPK</div>
                </div>
              </div>

              <!-- Button yang diperbarui -->
              <div class="dashboard-actions mt-4">
                <a href="#" class="btn btn-dashboard-primary">
                  <i class="bi bi-bar-chart-fill me-2"></i>
                  Akses Dashboard
                </a>
                <a href="#" class="btn btn-dashboard-outline">
                  <i class="bi bi-download me-2"></i>
                  Unduh Laporan
                </a>
              </div>
            </div>
          </div>
          <!-- End Kolom kiri -->

          <!-- Kolom kanan untuk gambar -->
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="about-image">
              <img src="{{ asset('assets/img/chart.png') }}" alt="Dashboard Statistik SDM" class="img-fluid rounded-4">
            </div>
          </div>
          <!-- End Kolom kanan -->
          
        </div><!-- End About Us Content -->

      </div>
    </section><!-- /Why Us Section -->

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="hero-content" data-aos="zoom-in" data-aos-delay="200">
          <div class="content-wrapper">
            <div class="badge-wrapper">
              <span class="promo-badge">Connect With Us</span>
            </div>
            <h2>Our Media Social</h2>
            <p class="justified-text">Tetap terhubung dengan kami melalui akun Sosial Media resmi Biro SDMO Kehutanan untuk mendapatkan informasi terbaru seputar pengumuman dan kegiatan lainnya.<br>Jangan lupa tag akun kami pada setiap kegiatan atau aktivitas terkait, agar dapat kami bagikan kembali sebagai bentuk apresiasi dan dukungan terhadap semangat kolaborasi ASN.</p>
            <div class="action-section">
              <div class="main-actions">
                <a href="https://www.instagram.com/rosmo_kemenhut" class="btn btn-explore">
                  <i class="bi bi-instagram"></i>
                  Follow Us!
                </a>
              </div>

              <!-- <div class="quick-contact">
                <span class="contact-label">Butuh Bantuan?</span>
                <a href="tel:+1555123456" class="contact-link">
                  <i class="bi bi-email"></i>
                  Telp 021 - 5730342
                </a>
              </div> -->

            </div>
          </div>

          <div class="visual-element">
            <img src="{{ asset('assets/img/insta.gif') }}" alt="Travel Adventure" class="hero-image" loading="lazy">
            <div class="image-overlay">
              <div class="stat-item">
                <span class="stat-number">200+</span>
                <span class="stat-label">Post</span>
              </div>
              <div class="stat-item">
                <span class="stat-number">27K+</span>
                <span class="stat-label">Followers</span>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="benefits-showcase" data-aos="fade-up" data-aos-delay="400">
          <div class="benefits-header">
            <h3>Why Choose Our Adventures</h3>
            <p>Experience the difference with our premium travel services</p>
          </div>

          <div class="benefits-grid">
            <div class="benefit-card" data-aos="flip-left" data-aos-delay="450">
              <div class="benefit-visual">
                <div class="benefit-icon-wrap">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div class="benefit-pattern"></div>
              </div>
              <div class="benefit-content">
                <h4>Handpicked Destinations</h4>
                <p>Every location is carefully selected by our travel experts for authentic experiences</p>
              </div>
            </div>

            <div class="benefit-card" data-aos="flip-left" data-aos-delay="500">
              <div class="benefit-visual">
                <div class="benefit-icon-wrap">
                  <i class="bi bi-award"></i>
                </div>
                <div class="benefit-pattern"></div>
              </div>
              <div class="benefit-content">
                <h4>Award-Winning Service</h4>
                <p>Recognized for excellence with 5-star ratings and industry awards</p>
              </div>
            </div>

            <div class="benefit-card" data-aos="flip-left" data-aos-delay="550">
              <div class="benefit-visual">
                <div class="benefit-icon-wrap">
                  <i class="bi bi-heart"></i>
                </div>
                <div class="benefit-pattern"></div>
              </div>
              <div class="benefit-content">
                <h4>Personalized Care</h4>
                <p>Tailored itineraries designed around your preferences and travel style</p>
              </div>
            </div>
          </div>
        </div> -->

      </div>

    </section><!-- /Call To Action Section -->

  </main>
@endsection
